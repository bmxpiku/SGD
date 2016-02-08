<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2016-01-10
 * Time: 19:55
 */

namespace App\Models;

use App\Models\Connections;
use Request;

class Node extends CachedModel
{
    protected $table = 'nodes';

    public function saveRequest(Request $request) {

    }

    public static function getAll() {
        $conn =Connections::get();
        $nodes = self::get();
        $routers = array();
        foreach ($nodes as $key => $node) {
            $routers[$key]['node'] = $node;
            $from = $to = 0;
            foreach($conn as $connection) {
                if ($connection->connected_id == $node->id)  {
                    $from++;
                }
                if ($connection->connection_id == $node->id)  {
                    $to++;
                }
            }
            $routers[$key]['connections'] = $from;
            $routers[$key]['connections_to'] = $to;
        }

        return $routers;
    }
}