<?php

namespace App\Http\Controllers;

use Request;


use App\Models\Connections;
use App\Models\Node;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ConfigController extends Controller
{

	/* kolory to maski 32bit, zapisano w formacie HEX
		zolty - 0001
		zielony - 0002
		szary - 0004
		czerwony - 0008

	*/
    public function generateConfig($id){
    	$node = Node::find($id);
    	$loIP = $node['name'];
    	$connIP = $node['ip'];

    	$config = 'interface bridge add name="lo-bridge"; ip address add address='.$loIP.' interface=lo-bridge; ';
    	$config .= 'routing ospf network add area=backbone network='.$node['name'].'; ';
    	$connected = Connections::where('connected_id', $id)->get();
    	foreach($connected as $key => $connection){
    		$interface[$key] = $connection['interface1'];
    		$bitrate[$key] = $connection['bitrate'];
    		$network[$key] = $connection['network'];
    		$colour[$key] = $connection['colour'];
    		$test = explode('.', $network[$key]);
    		$mask = substr(strrchr($test[3], '/'), 1);
    		$netIP = $test[0].'.'.$test[1].'.'.$test[2].'.'.'1'.'/'.$mask;
    			// dorobic potem kolory, bitrate
    		$config .= 'ip address add address='.$netIP.' interface='.$interface[$key].'; ';
    		$config .= 'routing ospf network add area=backbone network='.$network[$key].'; ';
    		$config .= 'mpls ldp interface add interface='.$interface[$key].'; ';
    		// Traffic Eng
    		$config .= 'mpls traffic-eng interface add interface='.$interface[$key].' bandwidth='.$bitrate[$key].'M ';
    		if($colour[$key] == 'yellow'){
    			$config .= 'resource-class=0001; ';
    		}
    		elseif($colour[$key] == 'green'){
    			$config .= 'resource-class=0002; ';
    		}
    		elseif($colour[$key] == 'grey'){
    			$config .= 'resource-class=0004; '; 
    		}
    		elseif($colour[$key] == 'red'){
    			$config .= 'resource-class=0008; ';
    		}
    	}

    	$connect = Connections::where('connection_id', $id)->get();
    	foreach($connect as $key => $connection){
    		$interface[$key] = $connection['interface2'];
    		$bitrate[$key] = $connection['bitrate'];
    		$network[$key] = $connection['network'];
    		$colour[$key] = $connection['colour'];
    		$test = explode('.', $network[$key]);
    		$mask = substr(strrchr($test[3], '/'), 1);
    		$netIP = $test[0].'.'.$test[1].'.'.$test[2].'.'.'2'.'/'.$mask;
    		$config .= 'ip address add address='.$netIP.' interface='.$interface[$key].'; ';
    		$config .= 'routing ospf network add area=backbone network='.$network[$key].'; ';
    		$config .= 'mpls ldp interface add interface='.$interface[$key].'; ';
    		// Traffic Eng
    		$config .= 'mpls traffic-eng interface add interface='.$interface[$key].' bandwidth='.$bitrate[$key].'M ';
    		if($colour[$key] == 'yellow'){
    			$config .= 'resource-class=0001; ';
    		}
    		elseif($colour[$key] == 'green'){
    			$config .= 'resource-class=0002; ';
    		}
    		elseif($colour[$key] == 'grey'){
    			$config .= 'resource-class=0004; '; 
    		}
    		elseif($colour[$key] == 'red'){
    			$config .= 'resource-class=0008; ';
    		}
    	}
    	$config .= 'routing ospf instance set default mpls-te-area=backbone mple-te-router-id=lo-bridge distribute-default=never redistribute-connected=as-type-1 router-id='.$node['name'].'; ';

    	//MPLS
    	$config .= 'mpls ldp set enabled=yes lsr-id='.$node['name'].' transport-address='.$node['name'].'; ';
    	// Traffic Eng
    	$config .= 'mpls traffic-eng tunnel-path add use-cspf=yes name=dyn; ';



    	echo $config;
    }

    public function modifyConfig($id){
    	$node = Node::find($id);
    	$loIP = $node['name'];
    	$connIP = $node['ip'];

    }
	
	/**
	pole koloru zwraca ttablicę gdzie 0 oznacze nie a 1 tak
	color" => array:4 [▼
		0 => "0"
		1 => "0"
		2 => "0"
		3 => "0"
	  ]
	**/
	public function vplsView(Request $request) {
		if (Request::isMethod('post')) {
			
            $data = $request::all();
			
			dd($data);
		}
		$nodes = Node::get();
		
		return view('scripts.simulator.vpls')
            ->with('nodes', $nodes);
		
	}
}
