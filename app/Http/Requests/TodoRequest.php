<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Todo;

class TodoRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'details' => 'required|string',
            'status' => 'required|string|in:' . implode(',', Todo::getAllowedStatuses()),
        ];
    }
}
