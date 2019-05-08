@extends('default')
@section('content')
    <h1 class="grey">{{$objectName}} @if(Route::getCurrentRoute()->getActionMethod() === 'edit')<span class="small orange"> - Editar</span> @endif</h1>
    {!! Form::open(['url' => URL::route($routeName . '.update', $object->id), 'files' => true , 'class' => 'form-group my-2', 'method' => 'PUT']) !!}
    @foreach($fields as $key => $val)
        @php($required = !empty($val['required']))
        @php($class = !empty($val['class']) ? $val['class'] : '')
        @if($val['type'] != 'readonly')
            {!! Form::label($key, $val['description'], ['class' => 'mt-2']) !!}
        @endif
        @if($val['type'] == 'text')
            @if(empty($val['textarea']))
                {!! Form::text($key, $val['default'],['required' => $required, 'class' => 'form-control ' . $class]) !!}
            @else
                {!! Form::textarea($key, $val['default'],['required' => $required, 'class' => 'form-control textarea' . $class, 'id' => 'textarea']) !!}
            @endif
        @elseif($val['type'] == 'password')

            {!! Form::password($key,['required' => $required, 'class' => 'form-control ' . $class]) !!}
        @elseif($val['type'] == 'email')
            {!! Form::email($key,$val['default'],['required' => $required, 'class' => 'form-control ' . $class]) !!}
        @elseif($val['type'] == 'select')
            @if($val['default'] instanceof \Illuminate\Support\Collection)
                @php($defaultId = $val['default']->pluck('id')->toArray())
            @else
                @php($defaultId = $val['default'])
            @endif
            {!! Form::select($key,  $val['data'], $defaultId, ['required' => $required, 'class' => 'form-control ' . $class]) !!}
        @elseif($val['type'] == 'checkbox')
            <div class="form-group">
                @foreach($val['data'] as $k => $value)
                    <div class="form-check form-check-inline">
                        @php($checkIds = $val['default']->pluck('id')->toArray())
                        {!! Form::checkbox($key .'[]', $k, \in_array($k, $checkIds), ['required' => $required, 'class' => 'mx-1 form-check-input'. $class]) !!}
                        {!! Form::label($key, $value, ['class' => 'form-check-label']) !!}
                    </div>
                @endforeach
            </div>
        @endif

    @endforeach
    <div class="my-4">
        <a href="{{URL::previous()}}" class="btn btn-outline-secondary">Voltar</a>
        @if(Route::getCurrentRoute()->getActionMethod() ===  'edit')
            {!! Form::submit('Editar',['class' => 'btn btn-primary ']) !!}
        @endif
    </div>

    {!! Form::close() !!}

@endsection
@push('page-links')
@endpush
@push('page-script')

@endpush