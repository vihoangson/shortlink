<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use App\Services\FileService;
use Illuminate\Http\File;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UploadController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    public function uploadFile($f, $filename = null) {
        $path = '/files/' . $filename . '/';
        Storage::disk(config('app.storage_disk_chat'))
               ->putFileAs($path, $f, $filename);
        $upload           = new Upload;
        $upload->filename = $filename;
        $upload->path     = $path . $filename;
        $upload->disk     = config('app.storage_disk_chat');
        $upload->save();

        return $upload;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $uploadedFile = $request->file('file');
        $filename     = $request->input('filename');
        if (!(substr($uploadedFile->getMimeType(), 0, 5) == 'image')) {
            $filename = time() . '_' . $filename;
            $f        = $uploadedFile;
            $upload   = $this->uploadFile($f, $filename);

            return response()->json($upload);
        }

        if (!(substr($uploadedFile->getMimeType(), 0, 9) == 'image/gif')) {
            $img = Image::make($uploadedFile->path());
            if($img->getHeight() > 800 || $img->getWidth() >800){
                $img->orientate()
                    ->resize(800, 800, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
            }

            $filename   = time() . $uploadedFile->getClientOriginalName();
            $path_cache = storage_path('framework/cache/' . $filename);
            $img->save($path_cache);
            /** @var File $cccm */
            $cccm = new File($path_cache);
            $f    = $cccm->move(storage_path());
        } else {
            $filename = time() . '_' . $filename;
            $f        = $uploadedFile;
        }
        $upload = $this->uploadFile($f, $filename);

        return response()->json($upload);


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $upload = Upload::find($id);
        if ($upload->disk === 's3') {
            $upload->fullurl = config('filesystems.disks.s3.url_public') . $upload->path;
        } else {
            $upload->fullurl = '/storage/' . $upload->path;
        }

        return $upload;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }
}
