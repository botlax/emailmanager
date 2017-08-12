<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emails extends Model
{
	protected $table = 'emails';
  	protected $fillable = ['email', 'auto_respond', 'password', 'user_id'];
  	public $timestamps = false;

  	public function user(){
       return $this->belongsTo('App\User');
  	}

    public function forwards(){
        return $this->hasMany('App\Forward','email_id');
    }
}
