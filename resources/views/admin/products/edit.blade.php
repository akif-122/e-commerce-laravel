@extends('admin.layouts.app')


@section('style')
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/summernote/summernote-bs4.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('admin-assets/plugins/dropzone/dropzone.css') }}"> --}}
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Product</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form method="post" id="productForm" name="productForm">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="title">Title</label>
                                            <input type="text" value="{{ $product->title }}" name="title"
                                                id="title" class="form-control" placeholder="Title">
                                            <p class="d-block"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="slug">Slug</label>
                                            <input type="text" value="{{ $product->slug }}" name="slug" id="slug"
                                                class="form-control" placeholder="Slug">
                                            <p class="d-block"></p>

                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" cols="30" rows="10" class="summernote"
                                                placeholder="Description">{{ $product->description }}</textarea>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Media</h2>
                                <div id="image" class="dropzone dz-clickable">
                                    <div class="dz-message needsclick">
                                        <br>Drop files here or click to upload.<br><br>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="img_gallery">
                            @if ($productImages->isNotEmpty())
                                @foreach ($productImages as $images)
                                    <div class="col-3" id="img-wrap-{{ $images->id }}">
                                        <div class="card">
                                            <input type="text" name="img_array[]" value="{{ $images->id }}" />
                                            <img src="{{ asset('uploads/products/' . $images->image) }}"
                                                style="width: 100%; height:100px; object-fit: cover;" class="card-img-top "
                                                width="100%" alt="...">
                                            <div class="card-body">

                                                <a href="Javascript:void(0);" onclick="handleDelete({{ $images->id }})" class="btn btn-danger">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                        </div>




                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Pricing</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="price">Price</label>
                                            <input type="text" value="{{ $product->price }}" name="price"
                                                id="price" class="form-control" placeholder="Price">
                                            <p class="d-block"></p>

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="compare_price">Compare at Price</label>
                                            <input type="text" value="{{ $product->price }}" name="compare_price"
                                                id="compare_price" class="form-control" placeholder="Compare Price">
                                            <p class="text-muted mt-3">
                                                To show a reduced price, move the product’s original price into Compare at
                                                price. Enter a lower value into Price.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Inventory</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sku">SKU (Stock Keeping Unit)</label>
                                            <input type="text" value="{{ $product->sku }}" name="sku"
                                                id="sku" class="form-control" placeholder="sku">
                                            <p class="d-block"></p>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="barcode">Barcode</label>
                                            <input type="text" value="{{ $product->barcode }}" name="barcode"
                                                id="barcode" class="form-control" placeholder="Barcode">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox">

                                                <input class="custom-control-input"
                                                    {{ $product->track_qty == 'yes' ? 'checked' : '' }}
                                                    value="{{ $product->track_qty == 'yes' ? 'yes' : 'no' }}"
                                                    type="checkbox" id="track_qty" name="track_qty">
                                                <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                                <p class="d-block"></p>

                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="number" value="{{ $product->qty }}" min="0"
                                                name="qty" id="qty" class="form-control" placeholder="Qty">
                                            <p class="d-block"></p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product status</h2>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-control">
                                        <option {{ $product->status == '1' ? 'selected' : '' }} value="1">Active
                                        </option>
                                        <option {{ $product->status == '0' ? 'selected' : '' }} value="0">Block
                                        </option>
                                    </select>
                                    <p class="d-block"></p>

                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h2 class="h4  mb-3">Product category</h2>
                                <div class="mb-3">
                                    <label for="category">Category</label>
                                    <select onchange="categoryHanlder()" name="category" id="category"
                                        class="form-control">
                                        <option disabled selected>Select Category</option>

                                        @if ($categories->isNotEmpty())
                                            @foreach ($categories as $category)
                                                <option {{ $product->category_id == $category->id ? 'selected' : '' }}
                                                    value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                    <p class="d-block"></p>

                                </div>
                                <div class="mb-3">
                                    <label for="category">Sub category</label>
                                    <select name="sub_category"  id="sub_category" class="form-control  ">
                                        <option disabled selected>Select Sub Category</option>
                                        @foreach ($subCategories as $subCategory)
                                            <option {{ $product->sub_category_id == $subCategory->id ? "selected" : "" }} value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product brand</h2>
                                <div class="mb-3">
                                    <select name="brand" id="brand" class="form-control">
                                        @if ($brands->isNotEmpty())
                                            @foreach ($brands as $brand)
                                                <option {{ $product->brand_id == $brand->id ? 'selected' : '' }}
                                                    value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Featured product</h2>
                                <div class="mb-3">
                                    <select name="is_featured" id="is_featured" class="form-control">
                                        <option {{ $product->is_featured == 'no' ? 'selected' : '' }} value="no">No
                                        </option>
                                        <option {{ $product->is_featured == 'yes' ? 'selected' : '' }} value="yes">
                                            Yes</option>
                                    </select>
                                    <p class="d-block"></p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pb-5 pt-3">
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('customjs')
    <script src="{{ asset('admin-assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    {{-- <script src="{{ asset('admin-assets/plugins/dropzone/dropzone.js') }}"></script> --}}
    <script>
        $('.summernote').summernote({
            height: '150px'
        });

        // SUB CATEGORY HANLDER 
        function categoryHanlder() {
            cat = $("#category").val();

            $.ajax({
                url: "{{ route('admin.products.sub.category') }}",
                type: "post",
                "data": {
                    "category": cat
                },
                dataType: "json",
                success: function(res) {
                    // console.log(res);
                    if (res.sub_categories.length > 0) {

                        $("#sub_category").removeAttr("disabled");
                        $("#sub_category").find("option").not(":first").remove();

                        $.each(res.sub_categories, function(key, item) {
                            $('#sub_category').append(
                                `<option value='${item.id}' >${item.name}</option>`)
                        })

                    } else {
                        $("#sub_category").attr("disabled", "");

                    }
                }
            })
        }



        function checkIfError(elem, error) {
            $("#" + elem).addClass("is-invalid")
                .siblings("p").addClass("invalid-feedback")
                .html(error);
        }

        function checkIfNoError(elem) {
            $("#" + elem).removeClass("is-invalid")
                .siblings("p").removeClass("invalid-feedback")
                .html("");
        }

        $("#productForm").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('admin.products.update', $product->id) }}",
                type: "put",
                data: $("#productForm").serializeArray(),
                dataType: "json",
                success: function(res) {
                    console.log(res)
                    if (res.status) {
                        checkIfNoError("title");
                        checkIfNoError("slug");

                        window.location.href = "{{ route('admin.products.index') }}";

                    } else {
                        error = res.errors;

                        if (error.title) {
                            checkIfError("title", error.title);
                        } else {

                            checkIfNoError("title");
                        }

                        if (error.slug) {
                            checkIfError("slug", error.slug);
                        } else {

                            checkIfNoError("slug");
                        }

                        if (error.price) {
                            checkIfError("price", error.price);
                        } else {

                            checkIfNoError("price");
                        }

                        if (error.track_qty) {
                            checkIfError("track_qty", error.track_qty);
                        } else {

                            checkIfNoError("track_qty");
                        }

                        if (error.category) {
                            checkIfError("category", error.category);
                        } else {

                            checkIfNoError("category");
                        }

                        if (error.is_featured) {
                            checkIfError("is_featured", error.is_featured);
                        } else {

                            checkIfNoError("is_featured");
                        }

                        if (error.qty) {
                            checkIfError("qty", error.qty);
                        } else {

                            checkIfNoError("qty");
                        }


                        if (error.sku) {
                            checkIfError("sku", error.sku);
                        } else {

                            checkIfNoError("sku");
                        }


                    }

                }
            })

        })





        $("#title").change(function() {
            $.ajax({
                url: "{{ route('admin.categories.generateSlug') }}",
                type: "get",
                data: {
                    name: $("#title").val()
                },
                success: function(res) {
                    if (res.status) {
                        $("#slug").val(res.slug)
                    }
                }
            })
        })


        let id = "{{ $product->id }}"
        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            // init: function() {
            //     this.on('addedfile', function(file) {
            //         if (this.files.length > 1) {
            //             this.removeFile(this.files[0]);
            //         }
            //     });
            // },
            url: "{{ route('admin.product.imageUpload') }}",
            params:{"id": id},
            maxFiles: 10,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(file, response) {
                // $(this).remove();
                // $("#image_id").val(response.image_id);
                console.log(response)
                let html = `
                    <div class="col-3" id="img-wrap-${response.image_id}">
                        <div class="card" >
                            <input type="text" name="img_array[]" value="${response.image_id}" />
                            <img src="${response.img_path}" style="width: 100%; height:100px; object-fit: cover;" class="card-img-top " width="100%" alt="...">
                            <div class="card-body">
                        
                                <a href="Javascript:void(0);" onclick="handleDelete(${response.image_id})" class="btn btn-danger">Delete</a>
                            </div>
                        </div>
                    </div>
                `;

                $("#img_gallery").append(html);
            }
        });


        // handleDelete
        function handleDelete(id){
            if(confirm("Are you sure you want to delete?")){
                $.ajax({
                    url : "{{ route("admin.product.imageDelete") }}",
                    type: "post",
                    data: {id},
                    success: function(res){
                        console.log(res)
                        $(`#img-wrap-${res.image_id}`).remove();
                    }
                })
            }
        }
        
        
    </script>
@endsection
