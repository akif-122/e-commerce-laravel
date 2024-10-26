<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //
    function index(Request $req)
    {

        $products = Product::latest()->with("product_images");

        if (!empty($req->keyword)) {
            $products = $products->where("title", "like", "%$req->keyword%");
        }
        $products = $products->paginate(10);
        // return $products;
        return view("admin.products.list", compact("products"));
    }


    function create(Request $req)
    {

        $data = [];
        $categories = Category::orderBy("name", "ASC")->get();
        $brands = Brand::orderBy("name", "ASC")->get();

        $data["categories"] = $categories;
        $data["brands"] = $brands;

        // return $data["categories"];
        return view("admin.products.create", $data);
    }


    function store(Request $req)
    {
        $rules = [
            "title" => "required",
            "slug" => "required",
            "price" => "required|numeric",
            "sku" => "required",
            // "track_qty" => "required|in:yes,no",
            "category" => "required|numeric",
            "is_featured" => "required",

        ];

        if (!empty($req->track_qty) && $req->track_qty == "yes") {
            $rules["qty"] = "required|numeric";
        }
        $validator = Validator::make($req->all(), $rules);

        if ($validator->passes()) {

            $product = new Product();
            $product->title = $req->title;
            $product->slug = $req->slug;
            $product->description = $req->description;
            $product->price = $req->price;
            $product->compare_price = $req->compare_price;
            $product->sku = $req->sku;
            $product->barcode = $req->barcode;
            if (empty($req->track_qty)) {
                $product->track_qty = "no";
            } else {
                $product->track_qty = $req->track_qty;
            }
            $product->qty = $req->qty;
            $product->status = $req->status;
            $product->category_id = $req->category;
            $product->sub_category_id = $req->sub_category;
            $product->brand_id = $req->brand;
            $product->is_featured = $req->is_featured;

            $product->save();

            if (!empty($req->img_array)) {



                foreach ($req->img_array as $temp_img_id) {

                    $tempImgInfo = TempImage::find($temp_img_id);
                    $ext_array = explode(".", $tempImgInfo->name);
                    $ext = last($ext_array);



                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                    $productImage->image = "null";
                    $productImage->save();

                    $imgName =  $productImage->id . "-" . time() . "." . $ext;

                    $productImage->image = $imgName;
                    $productImage->save();

                    $sPath = public_path() . "/temp" . "/" . $tempImgInfo->name;
                    $dPath = public_path() . "/uploads/products" . "/" . $imgName;


                    File::copy($sPath, $dPath);

                    File::delete($sPath);
                    TempImage::destroy($temp_img_id);
                }
            }
            session()->flash("success", "Product Added Successfully!");

            return response([
                "status" => true,
                "message" => "Product Added Successfully!"
            ]);
        } else {
            return response([
                "status" => false,
                "errors" => $validator->errors()
            ]);
        }
    }

    function edit($id)
    {



        $data = [];
        $product = Product::where("id", $id)->first();
        $subCategories = SubCategory::where("id", $product->sub_category_id)->get();
        // return $subCategorys;
        $productImages = ProductImage::where("product_id", $id)->get();
        // return $productImage;

        $categories = Category::orderBy("name", "ASC")->get();
        $brands = Brand::orderBy("name", "ASC")->get();

        $data["categories"] = $categories;
        $data["subCategories"] = $subCategories;
        $data["brands"] = $brands;
        $data["product"] = $product;
        $data["productImages"] = $productImages;

        return view("admin.products.edit", $data);
    }


    function update($id, Request $req)
    {
        // dd($req->input());
        $product = Product::find($id);

        $rules = [
            "title" => "required",
            "slug" => "required|unique:products,slug," . $product->id . ",id",
            "price" => "required|numeric",
            "sku" => "required|unique:products,sku," . $product->id . ",id",
            // "track_qty" => "required|in:yes,no",
            "category" => "required|numeric",
            "is_featured" => "required",

        ];

        if (!empty($req->track_qty) && $req->track_qty == "yes") {
            $rules["qty"] = "required|numeric";
        }
        $validator = Validator::make($req->all(), $rules);

        if ($validator->passes()) {

            $product->title = $req->title;
            $product->slug = $req->slug;
            $product->description = $req->description;
            $product->price = $req->price;
            $product->compare_price = $req->compare_price;
            $product->sku = $req->sku;
            $product->barcode = $req->barcode;
            if (empty($req->track_qty)) {
                $product->track_qty = "no";
            } else {
                $product->track_qty = $req->track_qty;
            }
            $product->qty = $req->qty;
            $product->status = $req->status;
            $product->category_id = $req->category;
            $product->sub_category_id = $req->sub_category;
            $product->brand_id = $req->brand;
            $product->is_featured = $req->is_featured;

            $product->save();

            // if (!empty($req->img_array)) {



            //     foreach ($req->img_array as $temp_img_id) {

            //         $tempImgInfo = TempImage::find($temp_img_id);
            //         $ext_array = explode(".", $tempImgInfo->name);
            //         $ext = last($ext_array);



            //         $productImage = new ProductImage();
            //         $productImage->product_id = $product->id;
            //         $productImage->image = "null";
            //         $productImage->save();

            //         $imgName =  $productImage->id . "-" . time() . "." . $ext;

            //         $productImage->image = $imgName;
            //         $productImage->save();

            //         $sPath = public_path() . "/temp" . "/" . $tempImgInfo->name;
            //         $dPath = public_path() . "/uploads/products" . "/" . $imgName;


            //         File::copy($sPath, $dPath);

            //         File::delete($sPath);
            //         TempImage::destroy($temp_img_id);
            //     }
            // }
            session()->flash("success", "Product Updated Successfully!");

            return response([
                "status" => true,
                "message" => "Product Updated Successfully!"
            ]);
        } else {
            return response([
                "status" => false,
                "errors" => $validator->errors()
            ]);
        }
    }


    function destroy($id){
        $product = Product::find($id);

        if(!$product){
            return response()->json([
                "status"=> false,
                "message"=> "Product Not Found!"
            ]);
        }


        $productImages = ProductImage::where("product_id", $product->id)->get();

        if(!empty($productImages)){
            foreach($productImages as $image){
                File::delete(public_path("uploads/products". $image->image));
            } 

            $productImages::where("product_id", $product->id)->delete();

        
        
    }
    
}
