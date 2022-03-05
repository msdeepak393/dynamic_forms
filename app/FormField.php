<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    protected $fillable = ['form_id', 'field_label', 'option_type_id'];

    public function options()
    {
        return $this->hasMany(FormFieldOption::class);
    }

    public function optionType()
    {
        return $this->belongsTo(OptionType::class);
    }
}
