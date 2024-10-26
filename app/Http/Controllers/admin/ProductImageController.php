<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductImageController extends Controller
{
    //
    function upload(Request $req)
    {
        $image = $req->image;
        $ext = $image->getClientOriginalExtension();

        $productImage = new ProductImage();
        $productImage->product_id = $req->id;
        $productImage->image = "null";
        $productImage->save();

        $imgName = $productImage->id . "-" . time() . "." . $ext;
        $productImage->image = $imgName;
        $productImage->save();


        $image->move(public_path("uploads/products/"), $imgName);

        return response()->json([
            "status"=> true,
            "image_id" => $productImage->id,
            "img_path"=> asset("uploads/products/". $imgName),
        ]);
        
    }

    function delete(Request $req){
        $productImage = ProductImage::find($req->id);

        $sPath = public_path("uploads/products/". $productImage->image);
        File::delete($sPath);

        $productImage->delete();

        return response()->json([
            "status"=> true,
            "image_id"=> $productImage->id
        ]);
        
    }
    
    
}
