@extends('default')
@section('content')
<form class="form-signin col-6 text-center mx-auto" method="post" action="{{URL::route('adm.login')}}">
    @csrf
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <div class="form-group">
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required autofocus>
    </div>
    <div class="form-group">
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
    </div>
    <div class="form-group">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
    </div>
</form>
@endsection