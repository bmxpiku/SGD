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
                Edytuj
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
