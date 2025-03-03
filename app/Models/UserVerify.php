<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVerify extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $table = 'user_verify';
    protected $guarded = [];

    function getUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(
            function ($post) {
                if($post->registration_paper != '' && file_exists(public_path() . $post->registration_paper))
                    unlink(public_path() .$post->registration_paper);
                if($post->company_logo != '' && file_exists(public_path() .$post->company_logo))
                    unlink(public_path() . $post->company_logo);
                if($post->cccd_front != '' && file_exists(public_path() .$post->cccd_front))
                    unlink(public_path() .$post->cccd_front);
                if($post->cccd_back != '' && file_exists(public_path() . $post->cccd_back))
                    unlink(public_path(). $post->cccd_back);
            }
        );
    }
}
