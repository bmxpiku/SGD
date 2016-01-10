<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2016-01-10
 * Time: 19:00
 */

namespace App\Http\Controllers;


use App\Models\Node;
use Redirect;
use Auth;
use Config;

class WelcomeController extends Controller
{

    public function index()
    {
        $nodes = Node::getAll();

        return view('layouts.master')
            ->with('nodes', $nodes);

    }

}