@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Brand</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.brand.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form method="post" name="brandForm" id="brandForm">
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
                                    <label for="email">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control"
                                        placeholder="Slug">
                                    <p class="d-block"></p>

                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label>Status</label>
                                    <select name="status" class="form-control" id="">
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary">Create</button>
                    <a href="{{ route('admin.brand.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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

        $("#brandForm").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('admin.brand.store') }}",
                type: "post",
                data: $("#brandForm").serializeArray(),
                dataType: "json",
                success: function(res) {

                    if (res.status) {
                        checkIfNoError("name");
                        checkIfNoError("slug");

                        window.location.href = "{{ route("admin.brand.index") }}";

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
