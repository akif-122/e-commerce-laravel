<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductImageController;
use App\Http\Controllers\admin\ProductSubCategoryController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\TempImageController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Flasher\Prime\FlasherInterface;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function (FlasherInterface $flasher) {
    // flash()->success('Your account has been re-activated.');

    // flash('Your account has been restored.');

    // flash()->success('Your account has been re-activated.');
    notify()->success('Laravel Notify is awesome!');
    return view('welcome');
});



Route::group(["prefix" => "admin"], function () {
    Route::group(["middleware" => "admin.guest"], function () {
        Route::get("/login", [AdminLoginController::class, "index"])->name("admin.login");
        Route::post("/authenticate", [AdminLoginController::class, "authenticate"])->name("admin.authenticate");
    });

    Route::group(["middleware" => "admin.auth"], function () {
        Route::get("/dashboard", [HomeController::class, "index"])->name("admin.dashboard");
        Route::get("/logout", [HomeController::class, "logout"])->name("admin.logout");

        // CATEGORIES ROUTES FOR ADMIN
        Route::group(["prefix" => "categories"], function () {
            Route::get("/", [CategoryController::class, "index"])->name("admin.categories.index");
            Route::get("/create", [CategoryController::class, "create"])->name("admin.categories.create");
            Route::post("/store", [CategoryController::class, "store"])->name("admin.categories.store");
            Route::get("/{category}/edit", [CategoryController::class, "edit"])->name("admin.categories.edit");
            Route::put("/{category}", [CategoryController::class, "update"])->name("admin.categories.update");
            Route::post("/delete", [CategoryController::class, "destroy"])->name("admin.categories.destroy");


            // TEMP IMAGE UPLOADING
            Route::post("/upload-temp-image", [TempImageController::class, "create"])->name("temp-images.create");
        });


        // SUB CATEGORIES ROUTES FOR ADMIN
        Route::group(["prefix"=> "sub-categories"], function(){
            Route::get("/", [SubCategoryController::class, "index"])->name("admin.sub-categories.index");
            Route::get("/create", [SubCategoryController::class, "create"])->name("admin.sub-categories.create");
            Route::post("/store", [SubCategoryController::class, "store"])->name("admin.sub-categories.store");
            Route::get("/{slug}/edit", [SubCategoryController::class, "edit"])->name("admin.sub-categories.edit");
            Route::put("/{slug}", [SubCategoryController::class, "update"])->name("admin.sub-categories.update");
            Route::delete("/delete", [SubCategoryController::class, "destroy"])->name("admin.sub_categories.destroy");

        });


        // BRAND ROUTE FOR ADMIN
        Route::group(["prefix"=> "brand"], function(){
            Route::get("/", [BrandController::class, "index"])->name("admin.brand.index");
            Route::get("/create", [BrandController::class, "create"])->name("admin.brand.create");
            Route::post("/store", [BrandController::class, "store"])->name("admin.brand.store");
            Route::get("/{slug}/edit", [BrandController::class, "edit"])->name("admin.brand.edit");
            Route::put("/update", [BrandController::class, "update"])->name("admin.brand.update");
            Route::post("/delete", [BrandController::class, "destroy"])->name("admin.brand.delete");
        });



        // PRODUCT ROUTES FOR ADMIN
        Route::group(["prefix"=> "products"], function(){
            Route::get("/", [ProductController::class, "index"])->name("admin.products.index");
            Route::get("/create", [ProductController::class, "create"])->name("admin.products.create");
            Route::post("/store", [ProductController::class, "store"])->name("admin.products.store");
            Route::get("/{product}/edit", [ProductController::class, "edit"])->name("admin.products.edit");
            Route::put("/{product}/update", [ProductController::class, "update"])->name("admin.products.update");


            Route::post("/image", [ProductImageController::class, "upload"])->name("admin.product.imageUpload");
            Route::post("/image/delete", [ProductImageController::class, "delete"])->name("admin.product.imageDelete");

            Route::post("/product-sub-category", [ProductSubCategoryController::class, "index"])->name("admin.products.sub.category");
        });
        
        
        
        // GET SLUG
        Route::get("/generate-slug", function (Request $req) {
            $slug = "";
            if (!empty($req->name)) {
                $slug  = Str::slug($req->name);
            }
            return [
                "status" => true,
                "slug" => $slug
            ];
        })->name("admin.categories.generateSlug");
    });
});
