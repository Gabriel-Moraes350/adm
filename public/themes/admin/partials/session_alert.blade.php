@if(!empty($errors) && \count($errors) > 0)
    <div class="alert alert-danger" role="alert">
        {{$errors->first()}}
    </div>
@elseif(!empty(session()->has('success')))
    <div class="alert alert-success" role="alert">
        {{session()->get('success')}}
    </div>
@endif
