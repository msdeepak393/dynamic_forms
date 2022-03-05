<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Form;
use App\FormField;
use App\FormFieldOption;
use App\OptionType;

class FrontendController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getFormData(Request $request)
    {
        $form = Form::with(['fields', 'fields.options','fields.optionType'])->orderBy('id','desc')->first();
        return response()->json(['data' => $form], 200);
    }
    
}
