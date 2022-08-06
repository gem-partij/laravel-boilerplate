<?php
namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class MongoUser extends Model
{
    use SoftDeletes;

    protected $connection = 'mongodb';
    protected $collection = 'users';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $guarded = [];
    // protected $fillable = [
    // ];

}