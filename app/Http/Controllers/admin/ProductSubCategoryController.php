<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ProductSubCategoryController extends Controller
{
    //

    function index(Request $req){
        $subCategories = SubCategory::where("category_id", $req->category)->get();

        return response([
            "status"=> true,
            "sub_categories" => $subCategories
        ]);
    }
}
