<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\File;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function uploadfile(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'file' => 'file|required',
            'directory_id' => 'exists:directories,id|nullable',
        ]);
        if ($request->has('file')) {
            $value = $request->file('file');
            $ext = $value->extension();
            if ($ext == null) {
                return response()->json('not allowed extension', 401);
            }
            if ($value->getSize() > 20971520) {
                return response()->json('limit of file size', 401);
            }
            if (!$this->canUpload($request->user_id, $value->getSize())) {
                return response()->json('limit of memory', 401);
            }
            $document = new File();
            if ($request->has('directory_id')) {
                $file = $request->file->store('public' .  '/' . $request->user_id . '/' . $request->directory_id);
                $document->directory_id = $request->directory_id;
            }


            $file = $request->file->store('public/' . $request->user_id);

            $document->weight=$value->getSize(); 
            $document->path = $file;
            $document->user_id = $request->user_id;
            $document->name = $value->getClientOriginalName();
            $document->save();

            return response()->json([
                "success" => true,
                "message" => "File successfully uploaded",
                "file" => $file,
                'name' => $document->name
            ]);
        }
    }
    public function renamefile(File $file, Request $request)
    {
        $request->validate([
            'name' => 'string|required',
        ]);
        $file = File::where('id', $file->id)->update($request->all());
        return response()->json(['status' => $file]);
    }
    public function downloadfile(File $file)
    {
        return Storage::download($file->path);
    }
    public function getfiles($user_id)
    {
        return File::where('user_id', $user_id)->get();
    }
    public function deletefile(File $file)
    {
        return response()->json(
            [
                'status' => $file->delete(),
            ]
        );
    }
    public function getPublicUrl(File $file){#
    return response()->json([
        'url'=>Storage::url($file->path)
    ]);
    }
    public function getDirectoryWeight($directory_id){
        $files=File::where('directory_id',$directory_id)->get();
        $size = $this->filesWeight($files);
        return response()->json($size);
        
     

    }
    public function getDiskWeight($user_id){
        $files=File::where('user_id',$user_id)->get();
        $size = $this->filesWeight($files);
        return response()->json($size);
     

    }
    protected function canUpload($user_id, $new_size)
    {
        $files = File::where('user_id', $user_id)->get();
        $size = $this->filesWeight($files);
        if ($size + $new_size > 104857600) {
            return false;
        }
        return true;
    }
    protected function filesWeight($files){
        $size = 0;
        foreach ($files as $file) {
            $size += $file  ->weight;
        }
        return $size;
    }
}
