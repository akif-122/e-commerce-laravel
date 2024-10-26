<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //
    function index(Request $req)
    {
        $categories = Category::latest();

        if (!empty($req->keyword)) {
            $categories = $categories->where("name", "like", "%$req->keyword%");
        }
        $categories = $categories->paginate(10);

        return view("admin.category.list", ["categories" => $categories]);
    }

    function create()
    {
        return view("admin.category.create");
    }

    function store(Request $req)
    {

        $validator = Validator::make($req->all(), [
            "name" => "required",
            "slug" => "required|unique:categories"
        ]);

        if ($validator->passes()) {

            $category = new Category();
            $category->name = $req->name;
            $category->slug = $req->slug;
            $category->status = $req->status;
            $category->save();




            if (!empty($req->image_id)) {
                session()->flash("success", "Category Added Successfully!");

                $tempImage = TempImage::find($req->image_id);
                $extArray = explode(".", $tempImage->name);
                $ext = last($extArray);

                $newImgName = $category->id . "." . $ext;
                $sPath = public_path() . '/temp/' . $tempImage->name;
                $dPath = public_path() . '/uploads/category/' . $newImgName;
                File::copy($sPath, $dPath);

                $category->image = $newImgName;
                $category->save();

                File::delete($sPath);
                TempImage::destroy($req->image_id);
            }
            session()->flash("success", "Category Added Successfully!");
            return [
                "status" => true,
                "msg" => "Category Added Successfully!"
            ];
        } else {
            return [
                "status" => false,
                "errors" => $validator->errors()
            ];
        }
    }

    function edit($category)
    {
        $category = Category::where("slug", $category)->first();
        // return var_dump($category);
        if ($category == null) {
            session()->flash("error", "Category not Found");
            return redirect()->route("admin.categories.index");
        }
        return view("admin.category.edit", ['category' => $category]);
    }

    function update($category, Request $req)
    {
        $cid = $category;
        $category = Category::where("id", $cid)->first();
        if ($category == null) {
            session()->flash("error", "Category sdfa  not Found");
            return [
                "status" => false,
                "message" => "Category Not Found!"
            ];
        }

        $validator = Validator::make($req->all(), [
            "name" => "required",
            "slug" => "required|unique:categories,slug," . $category->id . ",id"
        ]);


        if ($validator->passes()) {
            $category->name = $req->name;
            $category->slug = $req->slug;
            $category->status = $req->status;
            $category->save();




            if (!empty($req->image_id)) {

                $tempImage = TempImage::find($req->image_id);
                $extArray = explode(".", $tempImage->name);
                $ext = last($extArray);

                $newImgName = $category->id . "." . $ext;
                $sPath = public_path() . '/temp/' . $tempImage->name;
                $dPath = public_path() . '/uploads/category/' . $newImgName;
                File::copy($sPath, $dPath);

                $category->image = $newImgName;
                $category->save();

                File::delete($sPath);
                TempImage::destroy($req->image_id);
            }
            session()->flash("success", "Category Updated Successfully");
            return [
                "status" => true,
                "msg" => "Category Updated Successfully!"
            ];
        } else {
            return [
                "status" => false,
                "errors" => $validator->errors()
            ];
        }
    }

    function destroy(Request $req)
    {
        $cid = $req->category;
       
        $category = Category::where("id", $cid)->first();
        if ($category == null) {
            session()->flash("error", "Category  not Found");
            return [
                "status" => false,
                "message" => "Category Not Found!"
            ];
        }

        $delete = $category->destroy($cid);

        if($delete){
            $sPath = public_path(). "/uploads/category/" . $category->image;
            File::delete($sPath);
            session()->flash("success", "Category Deleted!");
            return [
                "status" => true,
                
            ];

        }
        
        
    }
}
