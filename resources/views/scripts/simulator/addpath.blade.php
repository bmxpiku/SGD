@extends('layouts.master')
@section('content')
<div class="col-md-10 col-md-offset-1">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">łączenie scieżek do rutera {{$self->ip}}</h3>
        </div>
        <div class="panel-body">
            {!! Form::open(array('class' => 'form-horizontal', 'route' => array('path', $self->id))) !!}
            <table class="table table-bordered">
                <thead>
                <th>ip</th>
                <th>czy połączony</th>
                <th>kolor</th>
                <th>przepustowosc w Mb</th>
                </thead>
                <tbody>
            @foreach($nodes  as $key => $node)
                @if ($self->id != $node->id)
                <tr>
                    <td>{{$node->ip}}</td>

                    {!! Form::hidden('rows['.$key.'][id]', $node->id) !!}
                    <td>
                        <?php $nameCheck = 'rows['.$key.'][checkbox]['.$node->id.']'; ?>
                        {!! Form::hidden($nameCheck, '0') !!}
                        {!! Form::checkbox($nameCheck, $node->id) !!}
                    </td>
                    <td>

                        {!! Form::select('rows['.$key.'][colour]', array('grey' => 'szary','green' => 'zielony', 'red' => 'czerwony', 'yellow' => 'żółty')
												, null, array('class' => 'form-control')) !!}
                    </td>
                    <td>
                        {!! Form::input('number', 'rows['.$key.'][bitrate]', '', array('class' => 'form-control', 'placeholder' => '10')) !!}
                    </td>
                </tr>
                @endif
            @endforeach
            </tbody>
            </table>

            {!! Form::submit('Aktualizuj', array('class' => 'btn btn-default btn-primary')) !!}
            {!! Form::close() !!}

        </div>
    </div>
</div>
@stop