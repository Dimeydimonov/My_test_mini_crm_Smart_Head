<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
{

    public function authorize(): bool
    {
        return $this->user() && $this->user()->hasRole('admin', 'manager');
    }

	public function rules(): array
	{
		return [

			'status' => 'required | in:new, in_progress, processed',

		];

	}

	public  function messages(): array
	{
		return [
			'status.required' => 'Статус обязателен',
			'status.in' => 'Недопустимое значение статуса ',
		];
	}

}
