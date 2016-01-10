<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2016-01-10
 * Time: 19:49
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CachedModel extends Model
{
    public $timestamps = false;
//    protected $table = 'jakax_nazwa';

    public static function getById($id) {

            return self::find($id);
    }
}