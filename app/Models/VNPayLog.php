<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VNPayLog extends Model
{
    public $timestamps = true;
    protected $table = 'vnpay_logs';
    protected $guarded =[];
}
