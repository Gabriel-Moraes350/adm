<nav class="navbar fixed-top navbar-expand-md navbar-dark bg-dark py-1">
    <div class="container">
        <a class="navbar-brand" href="{{route('adm.default')}}">Menu</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ml-auto">
            @if(Auth::check())
                <li class="nav-item active mx-2">
                    <a class="nav-link" href="{{URL::route('adm.user.index')}}">Usuários<span class="sr-only">(current)</span></a>
                </li>
                    <li class="nav-item active mx-2">
                        <a class="nav-link" href="{{URL::route('adm.role.index')}}">Níveis<span class="sr-only">(current)</span></a>
                    </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{URL::route('adm.logout')}}">Sair <span class="sr-only">(current)</span></a>
                </li>
            @endif
            </ul>
        </div>
    </div>
</nav>