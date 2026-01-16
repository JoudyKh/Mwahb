<?php

namespace App\Services\General\Course;

use App\Models\User;
use App\Models\Section;
use App\Constants\Constants;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use App\Http\Resources\Section\CourseResource;
use App\Http\Resources\Section\SectionResource;
use App\Http\Requests\Api\General\Courses\GetAllCoursesRequest;

class CourseService
{
    public function getMine(Request $request)
    {
        $user = User::with(['roles'])->where('id', auth('sanctum')->id())->first();

        $sections = Section::query();

        if ($user->hasRole(Constants::STUDENT_ROLE)) {
            $sections->where('sections.type', Constants::SECTION_TYPE_COURSES)
                ->withSubSectionLessonTimes() // keep the scope unchanged
                ->join('section_student', 'section_student.section_id', '=', 'sections.id')
                ->where('section_student.student_id', $user->id)
                ->groupBy([
                    'sections.id',
                    'sections.parent_id',
                    'sections.type',
                    'sections.name',
                    'sections.image',
                    'sections.description',
                    'sections.is_free',
                    'sections.price',
                    'sections.discount',
                    'sections.is_special',
                    'sections.intro_video',
                    'sections.created_at',
                    'sections.updated_at',
                    'sections.deleted_at',
                ])
                //i didnt put section_student.createt_at in the group by because i got problem with the paginate then
                ->select(
                    'sections.*',
                    DB::raw('MAX(section_student.created_at)'),
                    DB::raw('SUM(COALESCE(lessons.time, 0)) as total_lessons_time'),
                    DB::raw('1 as subscribed')
                )
                ->orderBy('sections.created_at', request()->query('OrderBy', 'desc'));
        }
        //if teacher return his courses
        else if ($user->hasRole(Constants::TEACHER_ROLE)) {
            $sections->where('sections.type', Constants::SECTION_TYPE_COURSES)
                ->withSubSectionLessonTimes() // Keep the scope unchanged
                ->join('course_teacher', 'course_teacher.course_id', '=', 'sections.id')
                ->where('course_teacher.teacher_id', $user->id)
                ->groupBy([
                    'sections.id',
                    'sections.parent_id',
                    'sections.type',
                    'sections.name',
                    'sections.image',
                    'sections.description',
                    'sections.is_free',
                    'sections.price',
                    'sections.discount',
                    'sections.is_special',
                    'sections.intro_video',
                    'sections.created_at',
                    'sections.updated_at',
                    'sections.deleted_at',
                ])
                ->select(
                    'sections.*',
                    DB::raw('MAX(course_teacher.created_at) as created_at'),
                    DB::raw('SUM(COALESCE(lessons.time, 0)) as total_lessons_time'),
                    DB::raw('1 as subscribed')
                )
                ->orderBy('created_at', request()->query('OrderBy', 'desc'));
        }


        return CourseResource::collection($sections->paginate(config('app.pagination_limit')));
    }

    public function getAll(GetAllCoursesRequest &$request)
    {
        $courses = Section::where('sections.type', Constants::SECTION_TYPE_COURSES);

        if (request()->has('is_special')) {
            $courses->where('sections.is_special', request()->has('is_special'));
        }

        $courses->withSubSectionLessonTimes();

        if ($request->has('student_id')) {
            $courses->whereHas('students', function ($users) use ($request) {
                $users->where('users.id', $request->input('student_id'));
            });
        }

        $courses = request()->boolean('paginate') ?
            $courses->paginate(config('app.pagination_limit')) :
            $courses->get();

        return CourseResource::collection($courses);
    }
}
