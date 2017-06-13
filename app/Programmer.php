<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Programmer extends Model
{
    public function programmers(){
    	return $this->hasMany('App\Programmer', 'name');
    }

}
