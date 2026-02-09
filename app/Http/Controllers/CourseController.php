<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditCourseRequest;
use App\Http\Requests\StoreCourseRequest;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Student;
use App\Models\Booking;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::paginate(10);
        $coursesCount = Course::all()->count();
        $recycleCount = Course::onlyTrashed()->count();
        return view('courses.index', compact('courses', 'coursesCount', 'recycleCount'));
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $searchTerm = $request->input('search');
            $searchBy = $request->input('search_by');

            $query = Course::query();

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
                'html' => view('courses.partials.course_table', compact('courses', 'searchTerm'))->render(),
                'pagination' => (string) $courses->links(),
                'count' => $courses->total()
            ]);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }

    public function show($id)
    {
        $course = Course::withTrashed()->findOrFail($id);
        $students = $course->students()->paginate(10);
        $studentsCount = $course->students()->count();
        return view('courses.view', compact('course', 'students', 'studentsCount'));
    }

    public function enrollmentSearch(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['error' => 'Invalid request'], 400);
        }

        $searchTerm = trim($request->input('search'));
        $searchBy = $request->input('search_by', 'all');
        $courseId = $request->input('course_id');

        if (!$courseId) {
            return response()->json(['error' => 'Course ID is missing'], 400);
        }

        $course = Course::withTrashed()->findOrFail($courseId);

        $query = $course->students(); // علاقة many-to-many

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

        $paginator = $query->paginate(10);

        return response()->json([
            'html' => view('courses.partials.enrollment_students_table', [
                'students' => $paginator,
                'searchTerm' => $searchTerm
            ])->render(),
            'pagination' => (string) $paginator->links(),
            'count' => $paginator->total(),
        ]);
    }


    public function create()
    {
        return view('courses.create');
    }
    public function store(StoreCourseRequest $request)
    {
        $saveData = $request->validated();
        $saveData['created_at'] = now();
        $saveData['updated_at'] = now();
        $course = Course::create($saveData);

        return redirect()->route('courses.show', $course->id)
            ->with('success', 'Course created successfully.');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('courses.edit', compact('course'));
    }

    public function update(EditCourseRequest $request, $id)
    {
        $course = Course::findOrFail($id);

        $updateData = $request->validated();
        $updateData['updated_at'] = now();
        $course->update($updateData);

        return redirect()->route('courses.show', $course->id)
            ->with('success', 'Course updated successfully.');
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }

    public function recycle()
    {
        $courses = Course::onlyTrashed()->paginate(10);
        $coursesCount = Course::onlyTrashed()->count();
        return view('courses.recycle', compact('courses', 'coursesCount'));
    }


    public function recycleSearch(Request $request)
    {
        if ($request->ajax()) {
            $searchTerm = $request->input('search');
            $searchBy = $request->input('search_by');

            $query = Course::onlyTrashed();

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

        return response()->json(['error' => 'Invalid request'], 400);
    }

    public function restore($id)
    {
        $course = Course::onlyTrashed()->findOrFail($id);
        $course->restore();

        return redirect()->route('courses.show', $course->id)
            ->with('success', 'Course restored successfully.');
    }

    public function deletePermanently($id)
    {
        $course = Course::onlyTrashed()->findOrFail($id);
        $course->forceDelete();

        return redirect()->route('courses.recycle')
            ->with('success', 'Course permanently deleted successfully.');
    }
}
