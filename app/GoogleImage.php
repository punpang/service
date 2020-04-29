<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Image;
use Storage;

class GoogleImage extends Model
{
    //protected $table = 'google_images';
    //public $timestamps = false;

    public static function store($image)
    {
        return $image->store('', 'google');
    }

    public static function findPath($fileName)
    {
        $listContents = Storage::disk('google')->listContents();

        foreach ($listContents as $listContent) {
            if ($listContent['name'] == $fileName) {
                $pathName['path'] = $listContent['path'];
            }
        }
        /*
        $google = new GoogleImage;
        $google->path = $pathName['path'];
        $google->save();
        */
        return $pathName['path'];
    }

    public static function StoreAndFindPath($image)
    {
        $fileName = GoogleImage::store($image);
        return GoogleImage::findPath($fileName);
    }
}
