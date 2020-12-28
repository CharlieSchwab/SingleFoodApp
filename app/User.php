<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';

    public function package(){
        return $this->belongsTo(PackageModel::class, "package_id");
	}


    public function restaurant(){
        return $this->belongsTo(User::class, "restaurant_id");
	}


	public function getweek() {
		return $this->hasMany(UserTimeModel::class, "user_id");
	}

	static public function getUser() {
		//return self::where('status', '=', '0')->get();
		return self::where('status', '=', '0')->where('is_delete','=','0')->whereIn('is_admin', [1, 2])->get();
	}
	
}
