<?php
namespace Geldfrei\Plymouth;
use Faker\Provider\File;
use Intervention\Image\ImageManager;

/**
 * Created by PhpStorm.
 * User: raphi
 * Date: 29.03.18
 * Time: 18:36
 */
class PlymouthTheme
{
    private $name;
    private $pathname;
    private $boilderplate;
    private $tmp_name;
    private $tmp_folder;

    private $logo;

    private $bg_color;
    private $bg_image;

    private $spinner_image;

    public function __construct($name)
    {
        /*
         * set name
         */
        $this->name = $name;
        $this->setPathname($name);

        /*
         * logo
         */
        $this->logo = false;

        /*
         * spinner
         */
        $this->spinner_image = false;

        /*
         * background
         */
        $this->bg_image = false;
        $this->bg_color = '373737'; // default grey

        /*
         * default Boilerplate
         */
        $this->setBoilerplate(base_path('packages/geldfrei/plymouth/src/boilerplate'));

        /*
         * temp directory and unique name
         */
        $this->tmp_name = uniqid('plymouth-');
        $this->tmp_folder = storage_path('plymouth/' . $this->tmp_name);

        if(!is_dir($this->tmp_folder))
        {
            mkdir($this->tmp_folder);
        }
    }

    public function render()
    {
        /*
         * create temp plymouth theme folder and copy files
         */
        $this->copyBoilerplateToTempFolder();

        /*
         * move script files
         */
        $this->generateScriptFiles();

        /*
         * generate logo image
         */
        $this->generateLogo();

        /*
         * generate logo image
         */
        $this->generateSpinner();

        /*
         * generate the background color and | or image
         */
        $this->generateBackground();
    }

    private function generateSpinner()
    {
        if($this->spinner_image)
        {
            unlink($this->tmp_folder . '/spinner.png');
            $manager = new ImageManager(array('driver' => 'imagick'));
            $image = $manager->make($this->spinner_image);
            $image->resize(48, 48, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $image->save($this->tmp_folder . '/spinner.png');
            unlink($this->spinner_image);
        }
    }

    private function generateBackground()
    {

        $wallpaper = null;


        /*
         * wenn wallpaper gesetzt ersetzte default
         */
        if($this->bg_image)
        {
            $manager = new ImageManager(array('driver' => 'imagick'));
            // to finally create image instances
            $image = $manager->make($this->bg_image);

            $image->resize(1920, 1080, function ($constraint) {
                $constraint->aspectRatio();
            });

            $image->save($this->tmp_folder . '/wallpaper.png');

        }
        /*
         * wenn kein wallpaper generiere farbigen hintergrund
         */
        else
        {
            $manager = new ImageManager(array('driver' => 'imagick'));
            $wallpaper = $manager->canvas(1920, 1080, '#' . strtolower($this->bg_color));
            $wallpaper->save($this->tmp_folder . '/wallpaper.png');
        }


    }

    private function generateLogo()
    {
        if($this->logo)
        {
            $manager = new ImageManager(array('driver' => 'imagick'));

            // to finally create image instances
            $image = $manager->make($this->logo);
            $image->resize(500, 400, function ($constraint) {
                $constraint->aspectRatio();
            });

            $image->save($this->tmp_folder . '/logo.png');
        }
        else
        {
            copy($this->tmp_folder . '/none.png', $this->tmp_folder . '/logo.png');
            unlink($this->tmp_folder . '/none.png');
        }

    }

    private function copyBoilerplateToTempFolder()
    {
        /*
         * erstelle verzeichnis wenn nicht vorhanden
         */
        if(!is_dir($this->tmp_folder))
        {
            mkdir($this->tmp_folder);
        }

        /*
         * kopiere dateien aus boilerplate verzeichnis
         */
        $files = glob($this->boilderplate . '/*');

        foreach ($files as $file)
        {
            \File::copy($file, $this->tmp_folder . '/' . basename($file));
        }
    }

    public function generateScriptFiles()
    {
        \File::copy($this->tmp_folder . '/theme.script', $this->tmp_folder . '/' . $this->pathname . '.script');
        unlink($this->tmp_folder . '/theme.script');

        $theme_file_content = $this->tpl($this->tmp_folder . '/theme.plymouth.template',[
            'name' => $this->name,
            'pathname' => $this->pathname
        ]);

        file_put_contents($this->tmp_folder . '/' . $this->pathname . '.plymouth', $theme_file_content);
        unlink($this->tmp_folder . '/theme.plymouth.template');
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setPathname($name)
    {
        $pathname = str_replace(
            [
                ' ',
                'ä',
                'ö',
                'ü',
                'Ä',
                'Ö',
                'Ü'
            ],
            [
                '-',
                'ae',
                'oe',
                'ue',
                'Ae',
                'Oe',
                'Ue'
            ],
            $name
        );

        $this->pathname = $pathname;
    }

    private function hex2rgb($hex) {
        $hex = str_replace("#", "", $hex);

        if(strlen($hex) == 3) {
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
        }
        $rgb = array($r, $g, $b);
        //return implode(",", $rgb); // returns the rgb values separated by commas
        return $rgb; // returns an array with the rgb values
    }

    public function saveZip($file)
    {
        /*
         * make zip file from folder
         */
        $zip = new \Chumper\Zipper\Zipper;
        $zip->make($file);
        $zip->folder($this->pathname)->add($this->tmp_folder);
        $zip->close();
    }

    public function destroy()
    {
        \File::deleteDirectory($this->tmp_folder);
    }

    private function tpl($file, $vars = [])
    {
        $content = file_get_contents($file);

        foreach ($vars as $key => $value)
        {
            $content = str_replace('{'.strtoupper($key).'}', $value, $content);
        }

        return $content;
    }

    public function getTmpPath()
    {
        return $this->tmp_folder;
    }

    public function getPathname()
    {
        return $this->pathname;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setBoilerplate($path)
    {
        $this->boilderplate = $path;
    }

    public function getBoilerplate()
    {
        return $this->boilderplate;
    }

    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    public function getLogo()
    {
        return $this->logo;
    }

    public function setBackgroundColor($color_hex_code)
    {
        $this->bg_color = $color_hex_code;
    }

    public function setBackgroundImage($path)
    {
        $this->bg_image = $path;
    }

    public function setSpinnerImage($path)
    {
        $this->spinner_image = $path;
    }
}