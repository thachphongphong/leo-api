<?php

namespace App\Http\Controllers;

use App\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;

class PhotoController extends Controller
{
    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function upload(Request $request)

    {
        Log::info("Upload photo: ". $request->title);

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'category' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($validator->fails()) {
            $error = $validator->messages()->toJson();
            Log::error($error);
            return response()->json('Invalid Extension', 500);
        }


        $input = $request->all();
        $input['image'] = time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('images'), $input['image']);


        $item = Photo::create($input);


        return response()->json([
            'success'=> true,
            'data'=> $item
        ]);

    }

    public function view()
    {
        $item= Photo::all();
        if($item == null){
            return response()->json('No photo', 200);
        }
        return response()->json([
            'success'=> true,
            'data'=> $item
        ]);
    }

    public function show($id)
    {
        $item = Photo::find($id);
        if($item == null){
            return response()->json('No photo', 200);
        }
        return response()->json([
            'success'=> true,
            'data'=> $item
        ]);
    }

    public function delete($id)
    {
        $item = Photo::find($id);
        if($item == null){
            return response()->json('No photo', 200);
        }else{
            //delete file
            $item->delete();
            unlink(public_path('images').'/'.$item->image);
        }
        return response()->json([
            'success'=> true,
            'data'=> $item
        ]);
    }

    public function file($filename)
    {
        $path = storage_path('public/images/' . $filename);

        if (!File::exists($path)) {
            response()->json('Image not found', 404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

}
