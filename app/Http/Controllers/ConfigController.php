<?php

namespace App\Http\Controllers;

use Request;


use App\Models\Connections;
use App\Models\Node;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\SshService;

class ConfigController extends Controller
{

	public function createConfig($id) {
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
    			$config .= 'resource-class=1; ';
    		}
    		elseif($colour[$key] == 'green'){
    			$config .= 'resource-class=2; ';
    		}
    		elseif($colour[$key] == 'grey'){
    			$config .= 'resource-class=4; '; 
    		}
    		elseif($colour[$key] == 'red'){
    			$config .= 'resource-class=8; ';
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
    			$config .= 'resource-class=1; ';
    		}
    		elseif($colour[$key] == 'green'){
    			$config .= 'resource-class=2; ';
    		}
    		elseif($colour[$key] == 'grey'){
    			$config .= 'resource-class=4; '; 
    		}
    		elseif($colour[$key] == 'red'){
    			$config .= 'resource-class=8; ';
    		}
    	}
    	$config .= 'routing ospf instance set default mpls-te-area=backbone mpls-te-router-id=lo-bridge distribute-default=never redistribute-connected=as-type-1 router-id='.$node['name'].'; ';

    	//MPLS
    	$config .= 'mpls ldp set enabled=yes lsr-id='.$node['name'].' transport-address='.$node['name'].'; ';
    	// Traffic Eng
    	$config .= 'mpls traffic-eng tunnel-path add use-cspf=yes name=dyn; ';
		
		return $config;
		
	}

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
	$config = $this->createConfig($id);
	$sshService = new SshService( $connIP, $node['login'], $node['password'], 22, '/tmp/log.txt' );
	$sshService->cmd($config);	
	//rozłączenie - zeby nie byłło wielu wiszących połączeń po wykonaniu instrukcji
	$sshService->disconnect();	
    	return redirect('/index');
    }
	
	public function showConfig($id) {
		$config = $this->createConfig($id);
		$confArray = explode(';',$config);
		return view('scripts.simulator.show')
            ->with('config', $confArray)
			->with('nodeID', $id);
	}
	
	public function showConfigAll(){
		$nodes = Node::get();
		$list = [];
		foreach ($nodes as $key=> $node) {
			$list[$key]['ip'] = $node->ip;
			$list[$key]['id'] = $node->id;
			$config = $this->createConfig($id);
			$list[$key]['config'] = explode(';',$config);
		}
		
		return view('scripts.simulator.showAll')
            ->with('list', $list);
	}
	
	public function generateConfigAll(){
		$nodes = Node::get();
		foreach ($nodes as $node) {
			$loIP = $node->name;
			$connIP = $node->ip;
			$config = $this->createConfig($node->id);
			$sshService = new SshService( $connIP, $node->login, $node->password, 22, '/tmp/log.txt' );
			$sshService->cmd($config);
			$sshService->disconnect();
			sleep(1);
		}
		
		return redirect('/index');
	}

    public function modifyConfig($id){
    	$node = Node::find($id);
    	$loIP = $node['name'];
    	$connIP = $node['ip'];

    }
	
	/**
	pole koloru zwraca ttablicę gdzie mamy wybrane kolory w kolejnosci
	0  'zolty NIE',
	1  'zolty TAK',
	2  'zielony NIE', 
	3  'zielony TAK',
	4  'szary NIE', 
	5  'szary TAK',
	6  'czerwony NIE', 
	7  'czerwony TAK'
	czyli np 
	"color" => array:4 [▼
		0 => "0"
		1 => "2"
		2 => "5"
		3 => "7"
	  ]
	**/
	public function vplsView(Request $request) {
		if (Request::isMethod('post')) {
			
            $data = $request::all();
            if(isset($data['color']))
			    $affinity = $this->makeMask($data['color']);
		    else
                $affinity = 15;

            $router1 = Node::getbyID($data['ruter1']);
            $router2 = Node::getbyID($data['ruter2']);
            $interface1 = $data['interface1'];
            $interface2 = $data['interface2'];

            //Traffic eng interface
            $config1 = 'interface traffic-eng add name='.$data['ruter1'].'to'.$data['ruter2'].' primary-path=dyn record-route=yes bandwidth='.$data['bitrate'].'M bandwidth-limit=100 affinity-include-any='.$affinity.' from-address='.$router1['name'].' to-address='.$router2['name'].' disabled=no; ';
            //VPLS
            $config1 .= 'interface vpls add name=vpls-'.$data['ruter1'].'to'.$data['ruter2'].' remote-peer='.$router2['name'].' vpls-id='.$data['ruter1'].':'.$data['ruter2'].' disabled=no; ';
            //Bridge VPLS and local interface
            $config1 .= 'interface bridge add name=vpls-bridge-'.$interface1.'; ';
            $config1 .= 'interface bridge port add bridge=vpls-bridge-'.$interface1.' interface=vpls-'.$data['ruter1'].'to'.$data['ruter2'].'; ';
            $config1 .= 'interface bridge port add bridge=vpls-bridge-'.$interface1.' interface='.$interface1.'; ';


            $config2 = 'interface traffic-eng add name='.$data['ruter2'].'to'.$data['ruter1'].' primary-path=dyn record-route=yes bandwidth='.$data['bitrate'].'M bandwidth-limit=100 affinity-include-any='.$affinity.' from-address='.$router2['name'].' to-address='.$router1['name'].' disabled=no; ';
            //VPLS
            $config2 .= 'interface vpls add name=vpls-'.$data['ruter2'].'to'.$data['ruter1'].' remote-peer='.$router1['name'].' vpls-id='.$data['ruter1'].':'.$data['ruter2'].' disabled=no; ';
            
            //Bridge VPLS and local interface
            $config2 .= 'interface bridge add name=vpls-bridge-'.$interface2.'; ';
            $config2 .= 'interface bridge port add bridge=vpls-bridge-'.$interface2.' interface=vpls-'.$data['ruter2'].'to'.$data['ruter1'].'; ';
            $config2 .= 'interface bridge port add bridge=vpls-bridge-'.$interface2.' interface='.$interface2.'; ';

            $sshService1 = new SshService( $router1['ip'], $router1['login'], $router1['password'], 22, '/tmp/log.txt' );
            $sshService1->cmd($config1);
            $sshService1->disconnect();
	
	    $sshService2 = new SshService( $router2['ip'], $router2['login'], $router2['password'], 22, '/tmp/log.txt' );
            $sshService2->cmd($config2);
            $sshService2->disconnect();


            return view('scripts.simulator.vplsConfig')->with(compact('config1', 'config2'));           
        }
		$nodes = Node::get();
		
		return view('scripts.simulator.vpls')
            ->with('nodes', $nodes);
		
	}
	
	//<DONE>napisałem service który wywkonuje te komendy
    /*public function sshExec($id) {
        $node = Node::getById($id);
        $connection =  ssh2_connect(Config::get('ssh.host'), Config::get('ssh.port'));
        if (!$connection) die('Connection failed');
        ssh2_auth_password($connection, Config::get('ssh.username') , Config::get('ssh.password'));
        $stream = ssh2_exec($connection, '/usr/local/bin/php -i');

        return Redirect::back();
    }*/
	
	/**
	Tutaj proponuje zrobic obliczanie maski na podstawie tablicy koloru
	Tak właśnie uczyniłem / bart
    **/
	private function makeMask($color) {
		$mask = 0;
		foreach($color as $col){
            		$mask += $col;
        }
		return $mask;
	}
}
