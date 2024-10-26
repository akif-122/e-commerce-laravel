<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Http\Request;

class TempImageController extends Controller
{
    //
    function create(Request $req)
    {
        $image = $req->image;

        if (!empty($image)) {
            $ext = $image->getClientOriginalExtension();
            
            
            $tmpImage = new TempImage();
            
            $tmpImage->name = "null";
            $tmpImage->save();
            
            
            $newName = $tmpImage->id . "-". time() . "." . $ext;
            $tmpImage->name = $newName;

            $tmpImage->save();

            
            $image->move(public_path()."/temp", $newName);

            $imgPath = $newName;
            
            return [
                "status" => true,
                "image_id" => $tmpImage->id,
                "img_path"=> $imgPath, 
            ]; 
        }
    }
}
