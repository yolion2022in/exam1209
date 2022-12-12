<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $dates = ['enabled_at'];

    //設定白名單 (允許的欄位)
    protected $fillable = [
        'subject',
        'content',
        'enabled_at',
        'sort',
        'pic',
        'enabled',
        'cgy_id',
    ];

    // protected $guarded=['*'];    //所有欄位均為黑名單
}
