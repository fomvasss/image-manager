<?php

namespace Fomvasss\ImageManager\Services;



use Carbon\Carbon;
use Intervention\Image\Facades\Image;

class ImageManager
{

    private $rootPath;

    private $originPath;

    private $imgPath;

    private $more;

    private $originFileName;

    private static $n = 0;

    /**
     * ImageManager constructor.
     */
    public function __construct()
    {
        $this->rootPath = public_path();

        $this->originPath = config('image_manager.origin.path');

        $this->imgPath = $this->rootPath .'/'. $this->originPath;

        $this->originFileName = config('image_manager.original_name');

        $this->more = config('image_manager.more');
    }

    /**
     * @param $files
     * @param null $titles
     * @param null $alts
     * @return array
     */
    public function store($files, $titles = null, $alts = null)
    {
        $names = $namesTitles = [];

        if (!is_dir($this->rootPath .'/'. $this->originPath)) {
            mkdir($this->rootPath .'/'. $this->originPath .'/', 0755, true);
        }
        $path = $this->rootPath . '/' . $this->originPath;

        if (is_array($files)) {
            foreach ($files as $i => $file) {
                $fileName = $this->getFileNameNew($file);
                $this->moreImages($file->getRealPath(), $fileName);
                $this->saveFile($file, $path, $fileName);

                if (empty($titles) && empty($alts)) {
                    $names[] = $fileName;
                } else {
                    $names[] = ['name' => $fileName, 'title' => empty($titles[$i]) ? null : $titles[$i], 'alt' => empty($alts[$i]) ? null : $alts[$i]];
                }
            }
            return $names;

        } else {
            $file = $files;
            $fileName = $this->getFileNameNew($file);
            $this->moreImages($file->getRealPath(), $fileName);
            $this->saveFile($file, $path, $fileName);

            return $fileName;
        }
    }

    /**
     * @param $file
     * @return bool
     */
    public function destroy($file)
    {
        if (is_file($this->imgPath .'/'. $file)) {
            unlink($this->imgPath .'/'. $file);
        }
        foreach ($this->more as $path) {
            if (is_file($this->imgPath .'/'. $path['path'].'/'.$file)) {
                unlink($this->imgPath .'/'. $path['path'].'/'.$file);
            }
        }
        return true;
    }


    public function regeneration()
    {
        $dir = $this->imgPath;
        $files = glob($dir.'/{,.}*', GLOB_BRACE); // get all file names

        foreach ($files as $file) {   //iterate files
            foreach ($this->more as $path) {
                if (is_file($this->imgPath .'/'. $path['path'].'/'.basename($file))) {
                    unlink($this->imgPath .'/'. $path['path'].'/'.basename($file));
                }
            }

            $this->moreImages($file, basename($file));
        }

        return true;
    }

    /**
     * @param $source
     * @param $newFileName
     * @return bool
     */
    private function moreImages($source, $newFileName)
    {
        foreach ($this->more as $key => $item) {
            if ($item['make'] == true && is_file($source) && filesize($source)>0)
            {
                is_dir($this->imgPath .'/'. $item['path']) ? null : mkdir($this->rootPath .'/'. $this->originPath .'/'. $item['path'], 0755, true );
                Image::make($source)->{$item['method']}($item['width'], $item['height'])->save($this->imgPath .'/'. $item['path'] .'/'. $newFileName, $item['compress']);
            }
        }
        return true;
    }

    /**
     * @param $file
     * @return string
     */
    private function getFileNameNew($file)
    {
        self::$n++;
        if ($this->originFileName) {
            return str_replace([' ', ':'], '-', $file->getClientOriginalName()). '_' .self::$n . '.' . $file->getClientOriginalExtension();
        }
        return str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString()) . '-' . self::$n . '.' . $file->getClientOriginalExtension();
    }

    private function saveFile($file, $path, $fileName)
    {
        if (config('image_manager.origin.make')) {
            $compress = config('image_manager.origin.compress');
            if (!empty($compress) && is_numeric($compress)) {
                Image::make($file->getRealPath())->save($path . $fileName, $compress);
            } else {
                $file->move($path, $fileName);
            }
        }
    }

}