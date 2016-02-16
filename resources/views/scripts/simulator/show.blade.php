@extends('layouts.master')
@section('content')
<hr>
Konfiguracja rutera <a href="/generate/{{$nodeID}}"><button class="btn btn-sm btn-danger">{{'Wyslij'}}</button></a>:
<table class="table table-bordered table-striped  table-condensed">
    <thead>
    <th>INSTRUKCJA</th>
    </thead>
    <tbody>
    @foreach($config as $conf)
        <tr>
            <td>
                {{$conf}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@stop
