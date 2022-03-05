<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormFieldOption extends Model
{
    protected $fillable = ['form_field_id','options'];
}
