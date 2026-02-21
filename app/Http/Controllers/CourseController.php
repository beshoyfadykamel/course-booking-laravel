<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EditCourseRequest;
use App\Http\Requests\StoreCourseRequest;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Student;
use App\Models\Booking;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CourseController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $this->authorize('viewAny', Course::class);
        $courses = Course::forCurrentUser()->with('user')->paginate(10);
        $coursesCount = Course::forCurrentUser()->count();
        $recycleCount = Course::onlyTrashed()->forCurrentUser()->count();
        return view('courses.index', compact('courses', 'coursesCount', 'recycleCount'));
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $this->authorize('viewAny', Course::class);
            $searchTerm = $request->input('search');
            $searchBy = $request->input('search_by');

            $query = Course::forCurrentUser()->with('user');

            if ($searchTerm) {
                if ($searchBy === 'title') {
                    $query->where('title', 'LIKE', "%{$searchTerm}%");
                } elseif ($searchBy === 'id') {
                    $query->where('id', 'LIKE', "%{$searchTerm}%");
                } elseif ($searchBy === 'status') {
                    $query->where('status', 'LIKE', "%{$searchTerm}%");
                } else {
                    $query->where(function ($q) use ($searchTerm) {
                        $q->where('title', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('status', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('id', 'LIKE', "%{$searchTerm}%");
                    });
                }
            }

            $courses = $query->with('user')->paginate(10);

            return response()->json([
                'html' => view('courses.partials.course_table', compact('courses', 'searchTerm'))->render(),
                'pagination' => (string) $courses->links(),
                'count' => $courses->total()
            ]);
        }

        return response()->json(['error' => __('messages.invalid_request')], 400);
    }

    public function show($id)
    {
        $course = Course::withTrashed()->forCurrentUser()->with('user')->findOrFail($id);
        $this->authorize('view', $course);
        $students = $course->students()->with('country')->paginate(10);
        $studentsCount = $course->students()->count();
        return view('courses.view', compact('course', 'students', 'studentsCount'));
    }

    public function enrollmentSearch(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['error' => __('messages.invalid_request')], 400);
        }

        $searchTerm = trim($request->input('search'));
        $searchBy = $request->input('search_by', 'all');
        $courseId = $request->input('course_id');

        if (!$courseId) {
            return response()->json(['error' => __('messages.course_id_missing')], 400);
        }

        $course = Course::withTrashed()->findOrFail($courseId);
        $this->authorize('view', $course);

        $query = $course->students()->with('country'); // علاقة many-to-many

        if ($searchTerm !== '') {
            $query->where(function ($q) use ($searchTerm, $searchBy) {

                if ($searchBy === 'id') {
                    $q->where('students.id', 'LIKE', "%{$searchTerm}%");
                } elseif ($searchBy === 'name') {
                    $q->where('students.name', 'LIKE', "%{$searchTerm}%");
                } elseif ($searchBy === 'status') {
                    $q->where('bookings.status', 'LIKE', "%{$searchTerm}%");
                } else { // all
                    $q->where('students.name', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('students.id', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('bookings.status', 'LIKE', "%{$searchTerm}%");
                }
            });
        }

        $students = $query->paginate(10);

        return response()->json([
            'html' => view('courses.partials.enrollment_students_table', [
                'students' => $students,
                'searchTerm' => $searchTerm
            ])->render(),
            'pagination' => (string) $students->links(),
            'count' => $students->total(),
        ]);
    }


    public function create()
    {
        $this->authorize('create', Course::class);
        return view('courses.create');
    }
    public function store(StoreCourseRequest $request)
    {
        $this->authorize('create', Course::class);
        $saveData = $request->validated();
        $saveData['user_id'] = Auth::id();
        $course = Course::create($saveData);

        return redirect()->route('courses.show', $course->id)
            ->with('success', __('messages.course_created_successfully'));
    }

    public function edit($id)
    {
        $course = Course::forCurrentUser()->findOrFail($id);
        $this->authorize('update', $course);
        return view('courses.edit', compact('course'));
    }

    public function update(EditCourseRequest $request, $id)
    {
        $course = Course::forCurrentUser()->findOrFail($id);
        $this->authorize('update', $course);

        $updateData = $request->validated();
        $updateData['updated_at'] = now();
        $course->update($updateData);

        return redirect()->route('courses.show', $course->id)
            ->with('success', __('messages.course_updated_successfully'));
    }

    public function destroy($id)
    {
        $course = Course::forCurrentUser()->findOrFail($id);
        $this->authorize('delete', $course);
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', __('messages.course_deleted_successfully'));
    }

    public function recycle()
    {
        $this->authorize('viewAny', Course::class);
        $courses = Course::onlyTrashed()->forCurrentUser()->with('user')->paginate(10);
        $coursesCount = Course::onlyTrashed()->forCurrentUser()->count();
        return view('courses.recycle', compact('courses', 'coursesCount'));
    }


    public function recycleSearch(Request $request)
    {
        if ($request->ajax()) {
            $this->authorize('viewAny', Course::class);
            $searchTerm = $request->input('search');
            $searchBy = $request->input('search_by');

            $query = Course::onlyTrashed()->forCurrentUser()->with('user');

            if ($searchTerm) {
                if ($searchBy === 'title') {
                    $query->where('title', 'LIKE', "%{$searchTerm}%");
                } elseif ($searchBy === 'id') {
                    $query->where('id', 'LIKE', "%{$searchTerm}%");
                } elseif ($searchBy === 'status') {
                    $query->where('status', 'LIKE', "%{$searchTerm}%");
                } else {
                    $query->where(function ($q) use ($searchTerm) {
                        $q->where('title', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('status', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('id', 'LIKE', "%{$searchTerm}%");
                    });
                }
            }

            $courses = $query->paginate(10);

            return response()->json([
                'html' => view('courses.partials.recycle_table', [
                    'courses' => $courses,
                    'searchTerm' => $searchTerm,
                ])->render(),
                'pagination' => (string) $courses->links(),
                'count' => $courses->total(),
            ]);
        }

        return response()->json(['error' => __('messages.invalid_request')], 400);
    }

    public function restore($id)
    {
        $course = Course::onlyTrashed()->forCurrentUser()->findOrFail($id);
        $this->authorize('restore', $course);
        $course->restore();

        return redirect()->route('courses.show', $course->id)
            ->with('success', __('messages.course_restored_successfully'));
    }

    public function deletePermanently($id)
    {
        $course = Course::onlyTrashed()->forCurrentUser()->findOrFail($id);
        $this->authorize('forceDelete', $course);
        $course->forceDelete();

        return redirect()->route('courses.recycle')
            ->with('success', __('messages.course_permanently_deleted'));
    }
}
