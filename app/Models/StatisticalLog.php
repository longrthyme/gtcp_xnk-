<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class StatisticalLog extends Model
{
   public $timestamps = true;
   protected $table = 'statistical_logs';
   protected $guarded =[];

   public function create_record($data)
   {
   	$user = auth()->user();
   	self::create($data);
   	return;
   }

   public function onlineUsers()
	{
	    $count = self::where('created_at', '>=', Carbon::now()->subMinutes(3))->count();
	    return $count;
	}

	public function pageVisitsToday()
	{
	    $count = self::whereDate('created_at', Carbon::today())->count();
	    return "Page visits today: $count people";
	}

	public function todaysVisits()
	{
	    $count = self::whereDate('created_at', Carbon::today())->count();
	    return "Today's visit: $count people";
	}

	public function yesterdaysVisits()
	{
	    $count = self::whereDate('created_at', Carbon::yesterday())->count();
	    return "Yesterday's visit: $count people";
	}

	public function monthlyVisits()
	{
	    $count = self::whereMonth('created_at', Carbon::now()->month)->count();
	    return "Monthly visits: $count people";
	}

	public function totalVisits()
	{
	    $count = self::count();
	    return $count;
	}

}
