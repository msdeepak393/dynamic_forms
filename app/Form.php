<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = ['user_id', 'name'];
    
    public function fields()
    {
        return $this->hasMany(FormField::class);
    }
}
