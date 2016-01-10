@extends('layouts.master')
@section('content')
Lista wszystkich ruterów w sieci:
<table class="table table-bordered table-striped  table-condensed">
    <thead>
    <th>ID</th>
    <th>Liczba połączeń</th>
    <th>ip</th>
    <th>
        Akcje
        <a href="/add">
            <button class="btn btn-sm btn-primary">{{'dodaj'}}</button>
        </a>
    </th>
    </thead>
    <tbody>
    @foreach($nodes as $node)
        <tr>
            <td>
                {{$node['node']->id}}
            </td>
            <td>
                {{$node['connections']}}
            </td>
            <td>
                {{$node['node']->ip}}
            </td>
            <td>
                <a href="/add/{{$node['node']->id}}">
                    <button class="btn btn-sm btn-info">{{'Edytuj'}}</button>
                </a>
                <a href="/path/{{$node['node']->id}}">
                    <button class="btn btn-sm btn-warning">{{'Ustal trasy'}}</button>
                </a>

                <a href="/path/{{$node['node']->id}}">
                    <button class="btn btn-sm btn-danger">{{'Wykonaj  komendy po ssh'}}</button>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@stop