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
            $amount = 0;
            foreach($conn as $connection) {
                if ($connection->connected_id == $node->id)  {
                    $amount++;
                }
            }
            $routers[$key]['connections'] = $amount;
        }

        return $routers;
    }
}