<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditCourseRequest;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Resources\Courses\CourseCollectionResource;
use App\Http\Resources\Courses\CourseResource;
use App\Models\Course;
use App\Traits\Api\ApiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    use ApiResponse, AuthorizesRequests;


    // ──────────────────────────────────────────────
    //  Collection endpoints
    // ──────────────────────────────────────────────

    public function index()
    {
        $this->authorize('viewAny', Course::class);
        $courses = Course::forApiIndex()->paginate(10);

        return $this->successPaginated(
            $courses,
            CourseCollectionResource::collection($courses->getCollection()),
            'courses',
            __('messages.courses_retrieved'),
            200
        );
    }

    public function recycle()
    {
        $this->authorize('viewAny', Course::class);
        $courses = Course::onlyTrashed()
            ->forApiIndex(['deleted_at'])
            ->paginate(10);

        return $this->successPaginated(
            $courses,
            CourseCollectionResource::collection($courses->getCollection()),
            'courses',
            __('messages.recycled_courses_retrieved'),
            200
        );
    }

    // ──────────────────────────────────────────────
    //  Single-resource endpoints
    // ──────────────────────────────────────────────

    public function show(Course $course)
    {
        $this->authorize('view', $course);
        return $this->courseResponse($course, __('messages.course_retrieved'));
    }

    public function store(StoreCourseRequest $request)
    {
        $this->authorize('create', Course::class);
        $course = Course::create([
            ...$request->validated(),
            'user_id' => Auth::id(),
        ]);

        return $this->courseResponse($course, __('messages.course_created'), 201);
    }

    public function update(EditCourseRequest $request, Course $course)
    {
        $this->authorize('update', $course);
        $course->update($request->validated());

        return $this->courseResponse($course, __('messages.course_updated'));
    }

    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);
        $course->delete();

        return $this->success(null, __('messages.course_deleted'), 200);
    }

    public function restore(Course $course)
    {
        $this->authorize('restore', $course);
        abort_unless($course->trashed(), 404);

        $course->restore();

        return $this->courseResponse($course, __('messages.course_restored'));
    }

    public function deletePermanently(Course $course)
    {
        $this->authorize('forceDelete', $course);
        abort_unless($course->trashed(), 404);

        $course->forceDelete();

        return $this->success(null, __('messages.course_permanently_deleted'), 200);
    }

    // ──────────────────────────────────────────────
    //  Private helpers
    // ──────────────────────────────────────────────

    private function courseResponse(Course $course, ?string $message = null, int $code = 200)
    {
        $course->loadCount('bookings');

        if (Auth::user()?->isAdmin()) {
            $course->load('user:id,name,email');
        }

        return $this->success(['course' => new CourseResource($course)], $message, $code);
    }
}
