@extends('layouts.master')
@section('content')
<div class="col-md-10 col-md-offset-1">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">Dodawanie nowego rutera</h3>
        </div>
        <div class="panel-body">
            {!! Form::open(array('class' => 'form-horizontal', 'route' => array('add'))) !!}

            <div class="form-group">
                <label for="name">Nazwa</label>
                {!! Form::input('text', 'name', '', array('class' => 'form-control', 'placeholder' => 'Nazwa')) !!}
            </div>
            <div class="form-group form-group-sm">
                <label for="ip">Ip</label>
                {!! Form::input('text', 'ip', '', array('class' => 'form-control', 'placeholder' => '127.0.0.1')) !!}
            </div>
            {!! Form::submit('Zapisz', array('class' => 'btn btn-default btn-success')) !!}
            {!! Form::close() !!}

        </div>
    </div>
</div>
@stop