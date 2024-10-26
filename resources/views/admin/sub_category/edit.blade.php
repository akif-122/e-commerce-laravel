@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Sub Category</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="subcategory.html" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" name="subCategoryForm" id="subCategoryForm">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" value="{{ $subCategory->name }}" name="name" id="name"
                                        class="form-control" placeholder="Name">
                                    <p class="d-block"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Slug</label>
                                    <input type="text" value="{{ $subCategory->slug }}" name="slug" id="slug"
                                        class="form-control" placeholder="Slug">
                                    <p class="d-block"></p>
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Category</label>
                                    <select name="category" id="category" class="form-control">
                                        <option disabled>Select Category</option>
                                        @if ($categories->isNotEmpty())
                                            @foreach ($categories as $category)
                                                <option {{ $subCategory->category_id == $category->id ? 'selected' : '' }}
                                                    value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="d-block"></p>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option {{ $subCategory->status == '1' ? 'selected' : '' }} value="1">Active
                                        </option>
                                        <option {{ $subCategory->status == '0' ? 'selected' : '' }} value="0">Block
                                        </option>
                                    </select>
                                    <p class="d-block"></p>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="subcategory.html" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('customjs')
    <script>
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

        $("#subCategoryForm").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('admin.sub-categories.update', $subCategory->slug) }}",
                type: "put",
                data: $("#subCategoryForm").serializeArray(),
                dataType: "json",
                success: function(res) {

                    if (res.status) {
                        console.log(res);

                        checkIfNoError("slug");
                        checkIfNoError("category");
                        checkIfNoError("name");

                        window.location.href = "{{ route("admin.sub-categories.index") }}";

                    } else {
                        error = res.errors;

                        if (error.name) {
                            checkIfError("name", error.name);
                        } else {

                            checkIfNoError("name");
                        }

                        if (error.slug) {
                            checkIfError("slug", error.slug);
                        } else {

                            checkIfNoError("slug");
                        }

                        if (error.category) {
                            checkIfError("category", error.category);
                        } else {

                            checkIfNoError("category");
                        }

                    }

                }
            })

        })





        $("#name").change(function() {
            $.ajax({
                url: "{{ route('admin.categories.generateSlug') }}",
                type: "get",
                data: {
                    name: $("#name").val()
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
            init: function() {
                this.on('addedfile', function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                });
            },
            url: "{{ route('temp-images.create') }}",
            maxFiles: 1,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(file, response) {

                $("#image_id").val(response.image_id);
                console.log(response)
            }
        });
    </script>
@endsection
