<?php

namespace App\Services;

use Illuminate\Http\File;
use Intervention\Image\Facades\Image;

class FileService {
    public function __construct(){

    }
    public function resizeImg($uploadedFile) {

        $uploadedFile->getClientOriginalExtension();
        $image           = Image::make($uploadedFile->path())
                                ->orientate();
        $filename_hashed = time() . '_' . md5($uploadedFile->getClientOriginalName()) . '.' . $uploadedFile->getClientOriginalExtension();
        $image->save(storage_path('framework/cache/' . 'origin_' . $filename_hashed));
        $image->fit(300, 300)
              ->save(storage_path('framework/cache/' . 'thumbnail_' . $filename_hashed));

        $img = Image::make($uploadedFile->path());
        // $img->resize(100,100);
        if ($image->width() > 650 && $image->height() > 650) {
            $img->orientate()
                ->fit(650, 650);
        }

        $img->orientate()
            ->fit(650, 650);
        $filename   = time() . $uploadedFile->getClientOriginalName();
        $path_cache = storage_path('framework/cache/' . $filename);
        $img->save($path_cache);
        /** @var File $cccm */
        $cccm = new File($path_cache);
        $f    = $cccm->move(storage_path());

        $upload = $this->uploadFile($f, $filename);

    }
}
