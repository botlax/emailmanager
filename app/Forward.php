<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forward extends Model
{
	protected $table = 'forwards';
  	protected $fillable = ['forward'];
  	public $timestamps = false;

  	public function emails(){
       return $this->belongsTo('App\Emails','email_id');
  	}

     
}
