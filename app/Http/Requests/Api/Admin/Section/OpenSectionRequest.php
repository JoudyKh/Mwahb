<?php

namespace App\Http\Requests\Api\Admin\Section;

use App\Models\Exam;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Section;
use App\Constants\Constants;
use App\Models\SectionStudent;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class OpenSectionRequest extends FormRequest
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
            'section_id' => [
                'bail',
                'required',
                'integer',
                Rule::exists('sections', 'id')
                    ->whereNull('deleted_at'),
                function ($attribute, $value, $fail) {
                    $lessons = Lesson::where('section_id', $value);
                    if ($lessons->doesntExist()) {
                        $fail(__('messages.section_has_no_lessons'));
                        return;
                    }

                }
            ],
            'student_id' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    $student = User::with('roles')
                        ->where('id', $value)
                        ->first();

                    if (!$student) {
                        $fail('user with id ' . $value . ' not found');
                        return;
                    }

                    $sectionStudent = SectionStudent::where([
                        'student_id' => $value,
                        'section_id' => $this->get('section_id'),
                    ]);

                    if ($sectionStudent->exists()) {
                        $fail(__('messages.student_already_own_the_section'));
                        return;
                    }

                    // if(!$student->is_active){
                    //     $fail(__('messages.student_is_not_active'));
                    //     return;
                    // }
        
                    if (!$student->hasRole(Constants::STUDENT_ROLE)) {
                        $fail('user is not a student');
                        return;
                    }
                }
            ],
        ];
    }
}
