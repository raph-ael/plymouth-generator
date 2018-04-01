<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Flysystem\File;
use Geldfrei\Plymouth\PlymouthTheme;
use App\PlymouthTheme as PlymouthThemeModel;

class PlymouthController extends Controller
{

    public function index()
    {
        return view('layouts.app');
    }

    public function generate(Request $request)
    {

        /*
         * init plymouth
         */
        $name = 'plymouth-generator-theme';

        if ($themename = request()->get('themename')) {
            $name = $themename;
        }


        $plymouth = new PlymouthTheme($name);

        /*
         * background color
         */
        if ($bgcolor = request()->get('bgcolor')) {
            $plymouth->setBackgroundColor($bgcolor);
        }

        /*
         * upload Logo
         */
        if($file = $request->file('logoimage')) {
            $img = uniqid('logo-') . '.' . request()->logoimage->getClientOriginalExtension();
            request()->logoimage->move(storage_path('uploads'), $img);
            $plymouth->setLogo(storage_path('uploads/' . $img));
        }

        /*
         * upload wallpaper
         */
        if($file = $request->file('bgimage'))
        {
            $img = uniqid('bgimage-').'.'.request()->bgimage->getClientOriginalExtension();
            request()->bgimage->move(storage_path('uploads'), $img);
            $plymouth->setBackgroundImage(storage_path('uploads/' . $img));
        }

        /*
         * upload spinner
         */
        if($file = $request->file('loaderimage'))
        {
            $img = uniqid('spinner-').'.'.request()->loaderimage->getClientOriginalExtension();
            request()->loaderimage->move(storage_path('uploads'), $img);
            $plymouth->setSpinnerImage(storage_path('uploads/' . $img));
        }

        $plymouth->render();

        $model = new PlymouthThemeModel();
        $model->name = $name;
        $model->pathname = $plymouth->getPathname();
        $model->logo = $plymouth->getLogo();
        $model->save();

        $filename = $model->id . '-' . $model->pathname . '.zip';

        $plymouth->saveZip(public_path('download/theme/' . $filename));

        $plymouth->destroy();

        return response()->json([
            'status' => 'success',
            'file' => $filename,
            'code' => 'wget -O - '.url('/install', $model->id).' | bash'
        ]);
    }

    public function install($id)
    {
        $theme = PlymouthThemeModel::find($id);

        echo "#!/bin/bash\n" .
            "clear\n" .
            "echo 'plymouth theme installation'\n" .
            "sudo su\n" .
            "mkdir /tmp/" . $theme->id . "\n" .
            "cd /tmp/" . $theme->id . "\n" .
            "wget ".url('download/theme/'.$theme->id.'-' . $theme->pathname . '.zip')."\n" .
            "unzip " . $theme->id . "-" . $theme->pathname . ".zip\n" .
            //"rm -rf /usr/share/plymouth/themes/" . $theme->pathname . "\n",
            "cp -r ./" . $theme->pathname . " /usr/share/plymouth/themes/\n" .
            "cd /tmp\n" .
            "rm -rf ./" . $theme->id . "\n" .
            "update-alternatives --install /usr/share/plymouth/themes/default.plymouth default.plymouth /usr/share/plymouth/themes/" . $theme->pathname . "/" . $theme->pathname . ".plymouth ".((int)$theme->id+100)."\n" .
            "echo $((`echo \"\" | update-alternatives --config default.plymouth | grep " . $theme->pathname . ".plymouth | cut -f 1 -d '/' | sed 's/[^0-9]//'`)) | update-alternatives --config default.plymouth\n" .
            "update-initramfs -u\n" .
            "exit\n";
            //'plymouthd ; plymouth --show-splash ; for ((I=0; I<3; I++)); do sleep 1 ; plymouth --update=test$I ; done ; plymouth --quit' . "\n";
    }


    private function getThemeFile($theme_name)
    {
        return '[Plymouth Theme]
Name='.$theme_name.'
Description=Presented by ' . url() . '
ModuleName=script

[script]
ImageDir=/usr/share/plymouth/themes/'.$theme_name.'
ScriptFile=/usr/share/plymouth/themes/stb-plymouth-theme/'.$theme_name.'.script
';
    }
}
