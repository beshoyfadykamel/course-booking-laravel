<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditCourseRequest;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Resources\Courses\CourseCollectionResource;
use App\Http\Resources\Courses\CourseResource;
use App\Models\Course;
use App\Traits\Api\ApiResponse;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    use ApiResponse;

    // ──────────────────────────────────────────────
    //  Collection endpoints
    // ──────────────────────────────────────────────

    public function index()
    {
        $courses = Course::forApiIndex()->paginate(10);
        
        return $this->success(['courses' => CourseCollectionResource::collection($courses)], __('messages.courses_retrieved'), 200);
    }

    public function recycle()
    {
        $courses = Course::onlyTrashed()
            ->forApiIndex(['deleted_at'])
            ->paginate(10);
        return $this->success(['courses' => CourseCollectionResource::collection($courses)], __('messages.recycled_courses_retrieved'), 200);
    }

    // ──────────────────────────────────────────────
    //  Single-resource endpoints
    // ──────────────────────────────────────────────

    public function show(Course $course)
    {
        return $this->courseResponse($course, __('messages.course_retrieved'));
    }

    public function store(StoreCourseRequest $request)
    {
        $course = Course::create([
            ...$request->validated(),
            'user_id' => 1,
        ]);

        return $this->courseResponse($course, __('messages.course_created'), 201);
    }

    public function update(EditCourseRequest $request, Course $course)
    {
        $course->update($request->validated());

        return $this->courseResponse($course, __('messages.course_updated'));
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return $this->success(null, __('messages.course_deleted'), 200);
    }

    public function restore(Course $course)
    {
        abort_unless($course->trashed(), 404);

        $course->restore();

        return $this->courseResponse($course, __('messages.course_restored'));
    }

    public function deletePermanently(Course $course)
    {
        abort_unless($course->trashed(), 404);

        $course->forceDelete();

        return $this->success(null, __('messages.course_permanently_deleted'), 200);
    }

    // ──────────────────────────────────────────────
    //  Private helpers
    // ──────────────────────────────────────────────

    private function courseResponse(Course $course, ?string $message = null, int $code = 200)
    {
        $course->load('user:id,name,email')
            ->loadCount('bookings');
        return $this->success(['course' => new CourseResource($course)], $message, $code);
    }
}
