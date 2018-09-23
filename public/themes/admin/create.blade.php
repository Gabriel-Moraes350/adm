@extends('default')
@section('content')
    <h1 class="grey">{{$objectName}}</h1>
    {!! Form::open(['url' => URL::route($routeName . '.store'), 'files' => true , 'class' => 'form-group', 'method' => 'POST']) !!}

    @foreach($fields as $key => $val)
        @php($required = !empty($val['required']))
        @php($class = !empty($val['class']) ? $val['class'] : '')
        @if($val['type'] != 'readonly')
        {!! Form::label($key, $val['description'], ['class' => 'mt-2']) !!}
        @endif
        @if($val['type'] == 'text')
            {!! Form::text($key, null,['required' => true, 'class' => 'form-control']) !!}
        @elseif($val['type'] == 'password')

            {!! Form::password($key,['required' => true, 'class' => 'form-control']) !!}
        @elseif($val['type'] == 'email')
            {!! Form::email($key,null,['required' => true, 'class' => 'form-control']) !!}
        @elseif($val['type'] == 'select')
            {!! Form::select($key,  $val['data'],null, ['required' => $required, 'class' => 'form-control']) !!}
        @elseif($val['type'] == 'checkbox')
            <div class="form-group">
                @foreach($val['data'] as $k => $value)
                    <div class="form-row">
                        {!! Form::checkbox($key . '[]', $k, null, ['required' => $required, 'class' => 'mx-1 '. $class]) !!}
                        {!! Form::label($key, $value) !!}
                    </div>
                @endforeach
            </div>
        @endif

    @endforeach
    <div class="my-3">
        <a href="{{URL::previous()}}" class="btn btn-outline-secondary">Voltar</a>
        {!! Form::submit('Criar',['class' => 'btn btn-primary my-2']) !!}
    </div>

    {!! Form::close() !!}
@endsection