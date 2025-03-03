<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class PackageDay extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "package_days";
    protected $guarded = [];

    public function getEndDate()
    {
        $now = Carbon::now();
        if($this->type == 'month')
            return $now->addMonths($this->day);
        elseif($this->type == 'year')
            return $now->addYears($this->day);
        elseif($this->type == 'day')
            return $now->addDays($this->day);
        return $now;
    }
}
