

@if ($flash_message = Session::get('flash-success'))
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse  "  style="justify-content: space-evenly;">
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{!! $flash_message !!}</strong>
        </div>
    </div>
</nav>
@endif

@if ($flash_message = Session::get('flash-error'))
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse  " style="justify-content: space-evenly;">
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{!! $flash_message !!}</strong>
        </div>
    </div>
</nav>
@endif
