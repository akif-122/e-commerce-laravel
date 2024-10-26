<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    //

    function index()
    {   
        $brands = Brand::orderBy("created_at", "DESC")->get();
        return view("admin.brand.list", compact("brands"));
    }

    function create()
    {
        return view("admin.brand.create");
    }


    function store(Request $req)
    {
        $vlaidator = Validator::make($req->all(), [
            "name" => "required",
            'slug' => "required|unique:brands"
        ]);

        if ($vlaidator->passes()) {

            $brand = new Brand();
            $brand->name = $req->name;
            $brand->slug = $req->slug;
            $brand->status = $req->status;
            $save = $brand->save();
            if($save){
                session()->flash("success", "New Brand added successfully!");
                return [
                    "status"=> true,
                    "message"=> "New Brand added successfully!"
                ];
            } 
            
        } else {
            return [
                "status" => false,
                "errors" => $vlaidator->errors()
            ];
        }
    }



    function edit($slug){
        $brand = Brand::where("slug", $slug)->first();

        if(!$brand){
            abort(404);
        }

        return view("admin.brand.edit", compact("brand"));
        
        
    }


    function update(Request $req){

        $brand = Brand::where("id", $req->id)->first();

        if(!$brand){
            return [
                "status"=> false,
                "message"=> "Brand not found!"
            ];
        }
        
        $vlaidator = validator::make($req->all(), [
            "name"=> "required", 
            "slug"=> "required|unique:brands,slug,". $req->id .",id"
        ]);

        if($vlaidator->passes()){

            $brand->name = $req->name;
            $brand->slug = $req->slug;
            $brand->status = $req->status;

            $save = $brand->save();
            if($save){
                session()->flash("success", "Brand Updated Successfully!");
                return [
                    "status"=> true,
                    "message"=> "Brand updated successfully!"
                ];
            }


        }else{
            return [
                "status"=> false, 
                "errors"=> $vlaidator->errors()
            ];
        }
        
    }


    function destroy(Request $req){
        $brand = Brand::findOrFail($req->id);

        $brand->delete();

        session()->flash("success", "Brand Deleted Successfully!");
        
        return [
            "status"=> true,
            "message"=> "Brand Deleted Successfully!"
        ];


    }
    
    
}
