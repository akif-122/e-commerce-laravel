@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Category</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            @include('admin.message')
            <form action="" name="categoryForm" id="categoryForm" method="post">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Name">
                                    <p class="d-block"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control"
                                        placeholder="Slug">
                                    <p class="d-block"></p>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <input type="text" name="image_id" id="image_id">
                                <label for="image">

                                    <div id="image" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">
                                            <br>Drop files here or click to upload.<br><br>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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
        $("#categoryForm").submit(function(e) {
            e.preventDefault();
            let element = $(this)
            $.ajax({
                url: "{{ route('admin.categories.store') }}",
                type: "post",
                data: $("#categoryForm").serializeArray(),
                dataType: "json",
                success: function(res) {

                    if (res.status) {
                        checkIfNoError("name");
                        checkIfNoError("slug");

                        window.location.href = "{{ route('admin.categories.index') }}";

                    } else {
                        let errors = res.errors;


                        // NAME
                        if (errors.name) {
                            checkIfError("name", errors.name);
                        } else {
                            checkIfNoError("name");
                        }

                        // SLUG
                        if (errors.slug) {
                            checkIfError("slug", errors.slug);
                        } else {
                            checkIfNoError("slug");
                        }
                    }
                },
                error: function(jqXHR, exception) {
                    console.log("Something goes wrong!");
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
