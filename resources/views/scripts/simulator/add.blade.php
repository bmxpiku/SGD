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
                <label for="name">ID do MPLS i OSPF(IP loopbacka)</label>
                {!! Form::input('text', 'name', '', array('class' => 'form-control', 'placeholder' => 'matrix')) !!}
            </div>
            <div class="form-group form-group-sm">
                <label for="ip">Ip</label>
                {!! Form::input('text', 'ip', '', array('class' => 'form-control', 'placeholder' => '127.0.0.1')) !!}
            </div>

            <div class="form-group form-group-sm">
                <label for="login">Login</label>
                {!! Form::input('text', 'login', '', array('class' => 'form-control', 'placeholder' => 'asterix')) !!}
            </div>

            <div class="form-group form-group-sm">
                <label for="password">Hasło</label>
                {!! Form::input('password', 'password', '', array('class' => 'form-control', 'placeholder' => 'obelix')) !!}
            </div>
            {!! Form::submit('Zapisz', array('class' => 'btn btn-default btn-success')) !!}
            {!! Form::close() !!}

        </div>
    </div>
</div>
@stop