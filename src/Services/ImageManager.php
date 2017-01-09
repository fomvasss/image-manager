<?php

namespace Fomvasss\ImageManager\Services;



use Carbon\Carbon;
use Intervention\Image\Facades\Image;

class ImageManager
{

    private $rootPath;

    private $originPath;

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

        if (is_dir($this->rootPath .'/'. $this->originPath)) {
            $path = $this->rootPath . '/' . $this->originPath;
        }
        else {
            mkdir($this->rootPath .'/'. $this->originPath .'/', 0755, true);
            $path = $this->rootPath . '/' . $this->originPath;
        }

        foreach ($files as $i => $file) {

            $fileName = $this->getFileNameNew($file);

            $this->moreImages($file->getRealPath(), $fileName);

            config('image_manager.origin.make') ? $file->move($path, $fileName) : null;

            $names[] = ['img' => $fileName, 'title' => empty($titles[$i]) ? null : $titles[$i], 'alt' => empty($alts[$i]) ? null : $alts[$i] ];
        }

        return $names;
    }

    /**
     * @param $file
     * @return bool
     */
    public function destroy($file)
    {
        if (file_exists($this->rootPath .'/'. $this->originPath .'/'. $file)) {
            unlink($this->rootPath .'/'. $this->originPath .'/'. $file);
        }
        foreach ($this->more as $path) {
            if (file_exists($this->rootPath .'/'.$path['path'].'/'.$file)) {
                unlink($this->rootPath .'/'.$path['path'].'/'.$file);
            }
        }
        return true;
    }


    public function regeneration()
    {
        $dir = $this->rootPath .'/'. $this->originPath;
        $files = glob($dir.'/{,.}*', GLOB_BRACE); // get all file names

        dd($files);


        foreach($files as $file){ // iterate files


            foreach ($this->more as $path) {
                if (file_exists($this->rootPath .'/'.$path['path'].'/'.$file)) {
                    unlink($this->rootPath .'/'.$path['path'].'/'.$file);
                }
            }

            //$this->moreImages($path, $fileName);

        }



    }

    /**
     * @param $source
     * @param $newFileName
     * @return bool
     */
    private function moreImages($source, $newFileName)
    {
        foreach ($this->more as $key => $item) {
            if ($item['make'] == true)
            {
                is_dir($this->rootPath .'/'. $item['path']) ? null : mkdir($this->rootPath .'/'. $item['path'], 0755, true );
                Image::make($source)->{$item['method']}($item['width'], $item['height'])->save($this->rootPath .'/'. $item['path'] .'/'. $newFileName, $item['compress']);
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

}