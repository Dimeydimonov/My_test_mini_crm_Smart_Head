<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
	        'phone_number' => ['required', 'string', 'regex:/^\+\d{10,15}$/'],
	        'email' => 'required|email|max:255',
	        'subject' => 'required|string|max:255',
	        'message' => 'required|string|max:2000',
	        'files'=>'nullable |array| max:10',
	        'files.*'=>'file|max:10240|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx',
        ];
    }
	public function messages(): array
	{
		return [

			'name.required' => ' Укажите ваше имя',
			'phone_number.required' => 'Укажите номер телефона',
			'phone_number.regex' => 'Номер должен быть в формате +1234567890',
			'email.required' => 'Укажите Email',
			'email.email' => 'Не верный формат Email',
			'subject.required' => 'Укажите тему заявки',
			'message.required' => 'Напишите сообщение',
			'files.*.max' => 'Файл не должен привышать 10MB',
		];
	}
}
