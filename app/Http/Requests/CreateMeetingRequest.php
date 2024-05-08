<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
class CreateMeetingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
          //initialize
          $rules = [];
          /**-------------------------------------------------------
           * common rules for both [create] and [update] requests
           * ------------------------------------------------------*/
          $rules += [
            'Attendee' => [
                'required',
            ],
            'Meeting' => [
                'required',
            ],
            //   'client_categoryid' => [
            //       'required',
            //       function ($attribute, $value, $fail) {
            //           if ($value != '') {
            //               if (!\App\Models\Category::where('category_type', 'client')->find(request('client_categoryid'))) {
            //                   return $fail(__('lang.invalid_category'));
            //               }
            //           }
            //       },
            //   ],
             ];

          //validate
          return $rules;
    }
     /**
     * Deal with the errors - send messages to the frontend
     */
    public function failedValidation(Validator $validator)
    {

        $errors = $validator->errors();
        $messages = '';
        foreach ($errors->all() as $message) {
            $messages .= "<li>$message</li>";
        }

        abort(409, $messages);
    }
}
