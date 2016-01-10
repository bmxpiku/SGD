<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2016-01-10
 * Time: 19:00
 */

namespace App\Http\Controllers;


use App\Models\Connections;
use App\Models\Node;
use Redirect;
use Auth;
use Config;
use Illuminate\Http\Request as RequestSave;
use Request;
use Session;

//<TODO>FLASHE
class WelcomeController extends Controller
{

    public function index()
    {
        $nodes = Node::getAll();

        return view('scripts.simulator.body')
            ->with('nodes', $nodes);

    }

    public function graph()
    {
        $nodes = Node::get();
        $conn = Connections::get();

        return view('scripts.simulator.graph')
            ->with('nodes', $nodes)
            ->with('conn', $conn);

    }

    public function jsonData(){
        $ret = view('layouts.data')->render();

        return response()->json($ret);
    }

    public function add(RequestSave $request, $id = null) {
        if(is_null($id)) {
            if (Request::isMethod('post')) {
                $node = new Node;
                $node->name  = $request->name;
                $node->ip  = $request->ip;
                $node->save();

            }



        }
        return view('scripts.simulator.add');
    }

    public function path(RequestSave $request, $id) {
        if (Request::isMethod('post')) {
            $data = $request->all();
            foreach($data['rows'] as  $row) {
                if ($row['checkbox'] !== '0') {
                    $conn = new Connections;
                    $conn->connected_id  = $id;
                    $conn->connection_id  = $row['id'];
                    $conn->colour  = $row['colour'];
                    $conn->bitrate  = $row['bitrate'];
                    $conn->save();
                }
            }
        }

        $nodes = Node::get();
        $connect = Connections::get();

        return view('scripts.simulator.addpath')
            ->with('nodes', $nodes)
            ->with('conn', $connect)
            ->with('self', Node::getById($id));
    }

    //<TODO>napisac  helper  do ssh
    public function sshExec($id) {
        $node = Node::getById($id);
        $connection =  ssh2_connect(Config::get('ssh.host'), Config::get('ssh.port'));
        if (!$connection) die('Connection failed');
        ssh2_auth_password($connection, Config::get('ssh.username') , Config::get('ssh.password'));
        $stream = ssh2_exec($connection, '/usr/local/bin/php -i');

        return Redirect::back();
    }
}