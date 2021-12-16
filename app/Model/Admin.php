<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

use Qbhy\HyperfAuth\Authenticatable;

class Admin extends Model implements Authenticatable
{
    protected $table = 'admin';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','name','password','status','created_at','updated_at'];

    protected $dates = ['created_at', 'updated_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];




    public function getId()
    {
        // TODO: Implement getId() method.
        // 返回用户id
        return $this->id;
    }

    public static function retrieveById($key): ?Authenticatable
    {
        // TODO: Implement retrieveById() method.
        // 通过id查找用户
        return self::query()->find($key);
    }



}