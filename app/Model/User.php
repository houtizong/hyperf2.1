<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;


class User extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'user_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','group_id','username','signature','face','password','email','regtime','lastlogin','status','subscribe'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];
}