<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Change this as per your application's authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'issue' => 'required|string|max:255', // Issue is required and must be a string
            'priority' => 'nullable|string|in:low,medium,high', // Optional, must be one of the defined values
            'status' => 'nullable|in:pending,open,solved', // Optional, must be a valid enum value
            'feedback' => 'nullable|string', // Optional, any text input
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:204800', // Optional, must be a valid image
        ];
    }

    /**
     * Get custom error messages for validation.
     */
    public function messages(): array
    {
        return [
            'issue.required' => 'The issue field is required.',
            'priority.in' => 'Priority must be one of the following: low, medium, or high.',
            'status.in' => 'Status must be one of the following: pending, open, or solved.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpg, jpeg, png.',
            'image.max' => 'The image size must not exceed 2MB.',
        ];
    }
}
