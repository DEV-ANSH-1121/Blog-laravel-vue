<?php

namespace App\Modules\Blog\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DeleteBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $return = false;
        if (Auth::check()) {
            $return =  true;
        } else {
            $return =  false;
        }
        return $return;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'uuid' => 'required|exists:blogs,uuid',
        ];
    }
}
