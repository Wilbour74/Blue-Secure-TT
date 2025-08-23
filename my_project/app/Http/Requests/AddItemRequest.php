<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddItemRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:Gourde,Couteau,Boussole,Carte,Briquet,Amadou,SacDeCouchage,Trousse,MateriauxTorche,Rations',
            'weight' => 'required|numeric|min:0',
            'volume' => 'required|numeric|min:0',
            'quantity' => 'nullable|numeric|min:0',
            'wear' => 'nullable|numeric|min:0|max:100',
        ];
    }
}
