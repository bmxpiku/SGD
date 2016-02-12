@extends('layouts.master')
@section('content')
<div class="col-md-10 col-md-offset-1">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">VPLS view</h3>
        </div>
        <div class="panel-body">
            {!! Form::open(array('class' => 'form-horizontal', 'route' => array('vpls'))) !!}
				
			<div class="form-inline">
				<h4>2 pola na wybór routerów, między którymi będzie VPLS</h4>
				<?php $list = []; ?>
				@foreach($nodes  as $key => $node)
					<?php $list[$node->id] = $node->name;?>
				@endforeach
				<div class="form-group form-group-sm">
					<label for="ruter2">ruter1</label>
					{!! Form::select('ruter1', $list, null, ['class' => 'form-control']) !!}
				</div>

				<div class="form-group form-group-sm" style="margin-left:50px">
					<label for="ruter2">ruter2</label>
					{!! Form::select('ruter2', $list, null, ['class' => 'form-control']) !!}
				</div>
			</div>
			<br>
			<div class="form-inline">
				<h4>2 pola na nazwy interfejsów, które są mostkowane przez VPLSa</h4>
				
				<div class="form-group form-group-sm">
					<label for="interface1">pole 1</label>
					{!! Form::input('text', 'interface1', null, array('class' => 'form-control')) !!}
				</div>

				<div class="form-group form-group-sm" style="margin-left:50px">
					<label for="interface2">pole 2</label>
					{!! Form::input('text', 'interface2', null, array('class' => 'form-control')) !!}
				</div>
			</div>
			<br>
			<div class="form-inline">
				<h4>definiowanie przepływności VPLSa</h4>
				<div class="form-group form-group-sm">
					<label for="bitrate">Przeplywnosc</label>
					{!! Form::input('number', 'bitrate', null, array('class' => 'form-control')) !!}
				</div>
			</div>
		<!--
		zolty - 0001
		zielony - 0002
		szary - 0004
		czerwony - 0008 -->
			<div class="form-inline">
				<h4>definiowanie przepływności VPLSa</h4>
				<div class="form-group form-group-sm">
					<label for="color">Kolor</label>
					{!! Form::select('color[]',array(
					 '0111111111111110' => 'zolty NIE',
					 '1111111111110001' => 'zolty TAK',
					 '0111111111111101' => 'zielony NIE', 
					 '1111111111110010' => 'zielony TAK',
					 '0111111111111011' => 'szary NIE', 
					 '1111111111110100' => 'szary TAK',
					 '0111111111110111' => 'czerwony NIE', 
					 '1111111111111000' => 'czerwony TAK'
					), null, array('multiple', 'class' => 'form-control mySelect', 'style'=>'width:200px;height:150px')) !!}
				</div>
			</div>
			
			<br>
            {!! Form::submit('Wyslij', array('class' => 'btn btn-default btn-success')) !!}
            {!! Form::close() !!}

        </div>
    </div>
</div>

<script>
$('.mySelect').change(function () {
    $(this).find('option').css('background-color', 'transparent');
    $(this).find('option:selected').css('background-color', 'red');
}).trigger('change');

</script>

@stop