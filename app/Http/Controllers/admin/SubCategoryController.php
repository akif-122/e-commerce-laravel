<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{


    function index(Request $req)
    {
        $subCategories = SubCategory::orderBy("created_at", "DESC");

        if ($req->keyword != null) {
            $subCategories = $subCategories->where("name", "like", "%$req->keyword%");
        }

        $subCategories =  $subCategories->with("parentCategory")->get();

        // return $subCategories;
        return view("admin.sub_category.list", compact("subCategories"));
    }

    //
    function create()
    {

        $categories = Category::orderBy("name", "ASC")->where("status", 1)->get();

        return view("admin.sub_category.create", compact("categories"));
    }

    function store(Request $req)
    {

        $validator = Validator::make($req->all(), [
            "name" => "required",
            "slug" => "required|unique:sub_categories",
            "category" => "required"
        ]);

        if ($validator->passes()) {


            $subCategory = new SubCategory();
            $subCategory->name = $req->name;
            $subCategory->category_id = $req->category;
            $subCategory->slug = $req->slug;
            $subCategory->status = $req->status;

            $save = $subCategory->save();

            if ($save) {
                session()->flash("success", "Sub Category Addedd Successfully!");
                return [
                    "status" => true
                ];
            }
        } else {
            return [
                "status" => false,
                "errors" => $validator->errors()
            ];
        }
    }



    function edit($slug)
    {
        $categories = Category::where("status", "1")->get();
        $subCategory = SubCategory::where("slug", $slug)->first();

        return view("admin.sub_category.edit", compact("categories", "subCategory"));
    }


    function update($slug, Request $req)
    {
        $subCategory = SubCategory::where("slug", $slug)->first();


        if ($subCategory == null) {
            session()->flash("error", "Sub Category   not Found");
            return [
                "status" => false,
                "message" => "Sub Category Not Found!"
            ];
        };
        $validator = Validator::make($req->all(), [
            "name" => "required",
            "slug" => "required|unique:sub_categories,slug," . $subCategory->id . ",id",
            "category" => "required"
        ]);
        if ($validator->passes()) {

            $subCategory->name = $req->name;
            $subCategory->slug = $req->slug;
            $subCategory->category_id = $req->category;
            $subCategory->status = $req->status;

            $save = $subCategory->save();

            if ($save) {
                session()->flash("success", "Sub Caegory Updated Successfully!");
                return [
                    "status" => true,
                    "errors" => null
                ];
            }
        } else {
            session()->flash("error", "Something goes wrong!");
            return [
                "status" => false,
                "errors" => $validator->errors()
            ];
        }
    }


    function destroy(Request $req)
    {
        $subCategory = SubCategory::where("id", $req->id)->first();
        if($subCategory == null){
            return [
                "status"=> false,
                "message"=> "Somethign goes wrong",
            ];
        }
        $delete = $subCategory->delete();
        if($delete){
            session()->flash("success", "Sub Category Deleted!");
            return[
                "status"=> true, 
                "message"=> "Sub Category Deleted!"
            ];
        }
    }
}
