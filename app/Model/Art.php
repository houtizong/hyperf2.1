<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

class Art extends Model
{
    protected $table = 'art';
    protected $primaryKey = 'art_id';

    protected $fillable = ['is_state'];
    protected $dates = [];
    protected $casts = [];

}