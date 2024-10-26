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
                    <h1>Create Product</h1>
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
                                            <input type="text" name="title" id="title" class="form-control"
                                                placeholder="Title">
                                            <p class="d-block"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="slug">Slug</label>
                                            <input type="text" name="slug" id="slug" class="form-control"
                                                placeholder="Slug">
                                            <p class="d-block"></p>

                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" cols="30" rows="10" class="summernote"
                                                placeholder="Description"></textarea>

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

                        </div>




                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Pricing</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="price">Price</label>
                                            <input type="text" name="price" id="price" class="form-control"
                                                placeholder="Price">
                                            <p class="d-block"></p>

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="compare_price">Compare at Price</label>
                                            <input type="text" name="compare_price" id="compare_price"
                                                class="form-control" placeholder="Compare Price">
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
                                            <input type="text" name="sku" id="sku" class="form-control"
                                                placeholder="sku">
                                            <p class="d-block"></p>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="barcode">Barcode</label>
                                            <input type="text" name="barcode" id="barcode" class="form-control"
                                                placeholder="Barcode">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox">

                                                <input class="custom-control-input" value="yes" type="checkbox"
                                                    id="track_qty" name="track_qty" checked>
                                                <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                                <p class="d-block"></p>

                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="number" min="0" name="qty" id="qty"
                                                class="form-control" placeholder="Qty">
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
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
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
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                    <p class="d-block"></p>

                                </div>
                                <div class="mb-3">
                                    <label for="category">Sub category</label>
                                    <select name="sub_category" disabled id="sub_category" class="form-control  ">
                                        <option disabled selected>Select Sub Category</option>

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
                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
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
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                    <p class="d-block"></p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pb-5 pt-3">
                    <button class="btn btn-primary">Create</button>
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
                url: "{{ route('admin.products.store') }}",
                type: "post",
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



        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            // init: function() {
            //     this.on('addedfile', function(file) {
            //         if (this.files.length > 1) {
            //             this.removeFile(this.files[0]);
            //         }
            //     });
            // },
            url: "{{ route('temp-images.create') }}",
            maxFiles: 10,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(file, response) {

                // $("#image_id").val(response.image_id);
                console.log(response)
                let html = `
                    <div class="col-3" >
                        <div class="card" >
                            <input type="text" name="img_array[]" value="${response.image_id}" />
                            <img src="/temp/${response.img_path}" style="width: 100%; height:100px; object-fit: cover;" class="card-img-top " width="100%" alt="...">
                            <div class="card-body">
                        
                                <a href="#" class="btn btn-danger">Delete</a>
                            </div>
                        </div>
                    </div>
                `;

                $("#img_gallery").append(html);
            }
        });
    </script>
@endsection
