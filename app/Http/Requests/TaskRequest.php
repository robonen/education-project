<?php

namespace App\Http\Requests;


class TaskRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'banktask_id' => 'required|exists:bank_tasks,id',
            'deadline' => 'required'

        ];
    }
}
