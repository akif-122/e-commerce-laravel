@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible ">
        <button class="close" data-dismiss="alert">x</button>
        <p class="m-0">{{ Session::get('success') }}</p>
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible ">
        <button class="close" data-dismiss="alert">x</button>
        <p class="m-0">{{ Session::get('error') }}</p>
    </div>
@endif
