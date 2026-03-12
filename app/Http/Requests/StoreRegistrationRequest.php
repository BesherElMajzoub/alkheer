<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'             => 'required|string|max:255',
            'phone'            => 'required|string|max:20',
            'area_id'          => 'required|exists:areas,id',
            'nearest_landmark' => 'nullable|string|max:255',
            'has_car'          => 'required|boolean',
            'available_seats'  => 'nullable|integer|min:1|max:20',
            'willing_to_drive' => 'nullable|boolean',
            'needs_ride'       => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'    => 'الاسم مطلوب',
            'phone.required'   => 'رقم الهاتف مطلوب',
            'area_id.required' => 'المنطقة مطلوبة',
            'area_id.exists'   => 'المنطقة المحددة غير صالحة',
            'has_car.required' => 'يرجى تحديد إذا لديك سيارة',
        ];
    }

    /**
     * Prepare the data for validation.
     * Derive missing boolean fields from the car status.
     */
    protected function prepareForValidation(): void
    {
        $hasCar = (bool) $this->input('has_car');

        if ($hasCar) {
            // If has car, doesn't need ride
            $this->merge([
                'needs_ride' => false,
                'willing_to_drive' => (bool) $this->input('willing_to_drive', false),
            ]);
        } else {
            // If no car, can't drive, set needs_ride based on user choice (default true)
            $this->merge([
                'available_seats' => null,
                'willing_to_drive' => false,
                'needs_ride' => (bool) $this->input('needs_ride', true),
            ]);
        }
    }

    /**
     * Get validated data with computed area text.
     */
    public function validatedWithArea(): array
    {
        $validated = $this->validated();

        // Set the area text from the area model for backward compat
        $area = \App\Models\Area::find($validated['area_id']);
        $validated['area'] = $area ? $area->name : '';

        return $validated;
    }
}
