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

        request()->validate([

            'logoimage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        /*
         * init plymouth
         */
        $name = 'test';
        $plymouth = new PlymouthTheme($name);

        /*
         * upload Logo
         */
        $img = uniqid('logo-').'.'.request()->logoimage->getClientOriginalExtension();
        request()->logoimage->move(storage_path('uploads'), $img);
        $plymouth->setLogo(storage_path('uploads/' . $img));

        if($bgcolor = request()->get('bgcolor'))
        {
            $plymouth->setBackgroundColor($bgcolor);
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
            'file' => $filename
        ]);
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
