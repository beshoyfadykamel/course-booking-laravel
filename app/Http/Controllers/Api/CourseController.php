<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditCourseRequest;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Resources\Courses\CourseCollection;
use App\Http\Resources\Courses\CourseShowResource;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::forApiIndex()->paginate(10);

        $coursesCount = $courses->total();
        $recycleCount = Course::onlyTrashed()->count();

        return (new CourseCollection($courses))
            ->additional([
                'meta' => [
                    'courses_count' => $coursesCount,
                    'recycle_count' => $recycleCount,
                ],
            ]);
    }

    public function show(Course $course)
    {
        $course->load(['user:id,name,email'])
            ->loadCount('bookings');

        $bookings = $course->bookings()
            ->forCourseShow()
            ->paginate(1);

        return (new CourseShowResource([
            'course' => $course,
            'bookings' => $bookings,
        ]))->response()->setStatusCode(200);
    }

    public function store(StoreCourseRequest $request)
    {
        $saveData = $request->validated();
        $saveData['user_id'] = 1;
        $course = Course::create($saveData);

        $course->load(['user:id,name,email'])
            ->loadCount('bookings');

        $bookings = $course->bookings()
            ->forCourseShow()
            ->paginate(1);

        return (new CourseShowResource([
            'course' => $course,
            'bookings' => $bookings,
        ]))->response()->setStatusCode(201);
    }

    public function update(EditCourseRequest $request, Course $course)
    {
        $updateData = $request->validated();
        $course->update($updateData);

        $course->load(['user:id,name,email'])
            ->loadCount('bookings');

        $bookings = $course->bookings()
            ->forCourseShow()
            ->paginate(1);

        return (new CourseShowResource([
            'course' => $course,
            'bookings' => $bookings,
        ]))->response()->setStatusCode(200);
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return response()->json([
            'message' => __('messages.course_deleted_successfully'),
        ], 200);
    }

    public function deletePermanently($id)
    {
        $course = Course::onlyTrashed()->findOrFail($id);
        $course->forceDelete();
        return response()->json([
            'message' => __('messages.course_permanently_deleted'),
        ], 200);
    }
}
