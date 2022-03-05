<?php

namespace App\Http\Controllers;

use App\Form;
use App\FormField;
use App\FormFieldOption;
use App\OptionType;
use Illuminate\Http\Request;

class FormController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createForm()
    {
        return view('createForm'); //createForm
    }

    public function getOptionTypes()
    {
        return response()->json(['data' => OptionType::all()], 200);
    }

    public function submitForm(Request $request)
    {
        $request->validate([
            'formName' => 'required',
            'dynamicForm' => 'required',
        ]);
        $form = Form::create([
            'user_id' => \Auth::user()->id,
            'name' => $request->formName,
        ]);
        if (!empty($request->dynamicForm)) {
            foreach ($request->dynamicForm as $dynamicForm) {
                $formField = FormField::create([
                    'form_id' => $form['id'],
                    'field_label' => $dynamicForm['label'],
                    'option_type_id' => $dynamicForm['optionType'],
                ]);
                if (!empty($dynamicForm['options'])) {
                    foreach ($dynamicForm['options'] as $option) {
                        FormFieldOption::create([
                            'form_field_id' => $formField->id,
                            'options' => $option['name'],
                        ]);
                    }
                }
            }
        }
        if ($form) {
            return response()->json(['message' => 'Your form created successfully'], 200);
        } else {
            return response()->json(['message' => "Unable to create form", 'error' => ''], 500);
        }
    }

    public function showForm()
    {
        return view('showForm'); //createForm
    }

    public function getForms()
    {
        return response()->json(['data' => Form::all()], 200);
    }

    public function deleteForms(Request $request, $id)
    {
        $formFileds = FormField::where('form_id', $id)->get();
        if (!$formFileds->isEmpty()) {
            foreach ($formFileds as $formFiled) {
                FormFieldOption::where('form_field_id', $formFiled->id)->delete();
            }
        }
        FormField::where('form_id', $id)->delete();
        $Form = Form::find($id);
        if ($Form) {
            $Form->delete();
        }
        return response()->json(['message' => 'Form deleted successfully'], 200);
    }

    public function getFormData(Request $request, $id)
    {
        $form = Form::with(['fields', 'fields.options'])->find($id);
        return response()->json(['data' => $form], 200);
    }

    public function updateForm(Request $request)
    {
        $request->validate([
            'formName' => 'required',
            'dynamicForm' => 'required',
        ]);
        $Form = Form::find($request->formId);
        $Form->user_id = \Auth::user()->id;
        $Form->name = $request->formName;
        $Form->save();
        if (!empty($request->dynamicForm)) {
            foreach ($request->dynamicForm as $dynamicForm) {
                $formField = FormField::updateOrCreate(
                    ['id' => $dynamicForm['id']],
                    ['form_id' => $request->formId, 'field_label' => $dynamicForm['field_label'], 'option_type_id' => $dynamicForm['option_type_id']]
                );
                if (!empty($dynamicForm['id'])) {
                    if (empty($dynamicForm['options'])) {
                        $FormFieldOptionDelete = FormFieldOption::where('form_field_id', $dynamicForm['id'])->delete();
                    }
                }
                if (!empty($dynamicForm['options'])) {
                    foreach ($dynamicForm['options'] as $option) {
                        $FormFieldOption = FormFieldOption::updateOrCreate(
                            ['id' => $option['id']],
                            ['form_field_id' => $formField->id, 'options' => $option['options']]
                        );
                    }
                }
            }
        }
        if (!empty($request->fieldDeletedId)) {
            foreach ($request->fieldDeletedId as $id) {
                FormFieldOption::where('form_field_id', $id)->delete();
                $FormFieldDelete = FormField::find($id);
                if ($FormFieldDelete) {
                    $FormFieldDelete->delete();
                }
            }
        }
        if (!empty($request->optionDeletedId)) {
            foreach ($request->optionDeletedId as $id) {
                $FormFieldOptionDelete = FormFieldOption::find($id);
                if ($FormFieldOptionDelete) {
                    $FormFieldOptionDelete->delete();
                }
            }
        }
        return response()->json(['message' => 'Your form updated successfully'], 200);
    }

}
