@extends('layouts.master')
@section('content')
<hr>
Konfiguracja rutera <a href="/generateAll"><button class="btn btn-sm btn-danger">{{'Wyslij'}}</button></a>:
<table class="table table-bordered table-striped  table-condensed">
    <thead>
    <th>INSTRUKCJA</th>
    </thead>
    <tbody>
    @foreach($list as $row)
        <tr class="info">
            <td>
                {{$row['ip']}}
            </td>
        </tr>
		@foreach($row['config'] as $config)
		<tr>
            <td>
                {{$config}}
            </td>
        </tr>
		@endforeach
    @endforeach
    </tbody>
</table>
@stop
