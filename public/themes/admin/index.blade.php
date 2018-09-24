@extends('default')
@section('content')
    <h1 class="grey">{{$objectName}}</h1>

    <div class="row my-2">
        <div class="col-6">
            @if(!$objects->isEmpty())
                <p class="">Mostrando: <strong>{{$objects->count()}}</strong> <br/>
                    Total: <strong>{{$objects->total()}}</strong>
                </p>
            @endif

            @if(!empty($index['showFilters']))
                <p>
                    {!! Form::open(['url' => URL::route(Route::getCurrentRoute()->getName()) , 'method' => 'GET', 'class' => 'form-row']) !!}
                    <div class="col">
                        <select name="filter" id="" class="form-control ">
                            @foreach($index['showFilters'] as $key => $val)
                                <option value="{{$key}}" @if(!empty($_REQUEST['filter']) && $_REQUEST['filter'] == $key) selected @endif>{{$val}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        {!! Form::text('find',Request::get('find'),['class'  => 'form-control']) !!}
                    </div>
                <div class="col"><button type="submit" class="btn btn-secondary">Buscar</button></div>
                    {!! Form::close() !!}
                </p>

            @endif
        </div>
        <div class="col-6">
            @if(!empty($index['actions']['create']))

                <a role="button" class="btn btn-primary float-right" href="{{URL::route($routeName . '.create')}}">Criar novo</a>
            @endif
        </div>
    </div>
    <div class="container">
        <div class="row">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    @foreach($index['showFields'] as $headerFields)
                        <th>{{$headerFields['description']}}</th>
                    @endforeach
                    @if(!empty($objects[0]->created_at))
                        <th>Criado em</th>
                    @endif
                    <th>Ações</th>
                </tr>
                </thead>
                @if(!$objects->isEmpty())
                    <tbody>
                    @foreach($objects as $value)
                        <tr>
                            <td>{{$value->id}}</td>
                            @foreach($index['showFields'] as $key => $val)
                                <td>{!! $value->{$key} !!}</td>
                            @endforeach
                            @if(!empty($value->created_at))
                                <td>{{$value->created_at}}</td>
                            @endif
                            <td>
                                @foreach($index['actions'] as $key => $val)
                                    @if(!empty($val))
                                        @if($key == 'destroy')
                                            <a href="{{URL::route($routeName .'.' .$key,$value->id)}}" class="remove-btn mx-1 p-1 rounded bg-danger"><i class="fas fa-trash-alt text-white"></i></a>
                                        @elseif($key == 'edit')
                                            <a href="{{URL::route($routeName .'.' .$key,$value->id)}}" class="edit-btn mx-1 p-1 rounded bg-success"><i class="fas fa-edit text-white"></i></a>
                                        @elseif($key == 'show')
                                            <a href="{{URL::route($routeName .'.' .$key,$value->id)}}" class="bg-primary view-btn p-1 rounded mx-1"><i class="far fa-eye text-white"></i></a>
                                        @endif

                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                @endif
            </table>
        </div>
    </div>
    @if(!$objects->isEmpty())
        <div class="row">
            @php($page = $objects->currentPage())
            @php($total = $objects->total())
            @php($perPage = $objects->perPage())
            <nav aria-label="">
                <ul class="pagination justify-content-center">
                    <li class="page-item @if(!Request::has('page') || $page == 1) disabled @endif">
                        <a class="page-link" href="{{$objects->url(1)}}" tabindex="-1">Primeira</a>
                    </li>
                    @if($page == 1)
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        @if($objects->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{$objects->url(2)}}">2 </a>
                            </li>
                            @if(\ceil($total/$perPage) >= 3)
                                <li class="page-item"><a class="page-link" href="{{$objects->url(3)}}">3</a></li>
                            @endif
                        @endif
                    @else
                        <li class="page-item"><a class="page-link" href="{{$objects->previousPageUrl()}}">{{$page - 1}}</a></li>
                        <li class="page-item active">
                            <a class="page-link" href="{{$objects->url($page)}}">{{$page}}</a>
                        </li>
                        @if($objects->hasMorePages())
                            <li class="page-item"><a class="page-link" href="{{$objects->nextPageUrl()}}">{{$page + 1}}</a></li>
                        @endif
                    @endif

                    <li class="page-item @if(!$objects->hasMorePages()) disabled @endif">
                        <a class="page-link " href="{{$objects->url($objects->lastPage())}}">Última</a>
                    </li>
                </ul>
            </nav>
        </div>
    @endif
@endsection
@push('page-script')
    <script>
        $(function(){
            $('.remove-btn').click(function(e){
                e.preventDefault();
                if(!confirm('Deseja excluir o item?'))
                {
                    return false;
                }
                var element = $(this);
                var route = $(this).attr('href');
                $.ajax({
                    url: route,
                    type: 'DELETE',  // user.destroy
                    dataType:'json',
                }).done(function(obj)
                {
                    if(obj.success)
                    {
                        element.closest('tr').remove();
                        alert('Sucesso');
                    }
                }).fail(function()
                {
                    alert('Erro');
                });



            });
        });
    </script>
@endpush