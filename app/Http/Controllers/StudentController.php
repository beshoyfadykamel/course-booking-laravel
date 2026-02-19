<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditStudentRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Models\Country;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('country')->paginate(10);
        $studentsCount = Student::with('country')->count();
        $recycleCount = Student::onlyTrashed()->count();
        return view('students.index', compact('students', 'recycleCount', 'studentsCount'));
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $searchTerm = $request->input('search');
            $searchBy = $request->input('search_by');

            $query = Student::query();

            if ($searchTerm) {
                if ($searchBy === 'name') {
                    $query->where('name', 'LIKE', "%{$searchTerm}%");
                } elseif ($searchBy === 'id') {
                    $query->where('id', 'LIKE', "%{$searchTerm}%");
                } elseif ($searchBy === 'status') {
                    $query->where('status', 'LIKE', "%{$searchTerm}%");
                } else {
                    $query->where(function ($q) use ($searchTerm) {
                        $q->where('name', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('status', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('id', 'LIKE', "%{$searchTerm}%");
                    });
                }
            }

            $students = $query->paginate(10);

            return response()->json([
                'html' => view('students.partials.student_table', compact('students', 'searchTerm'))->render(),
                'pagination' => (string) $students->links(),
                'count' => $students->total()
            ]);
        }

        return response()->json(['error' => __('messages.invalid_request')], 400);
    }


    public function create()
    {
        $countries = Country::all();
        return view('students.create', compact('countries'));
    }

    public function store(StoreStudentRequest $request)
    {


        $saveData = $request->validated();
        $saveData['created_at'] = now();
        $saveData['updated_at'] = now();

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $filename = Str::uuid() . '.' . strtolower($file->getClientOriginalExtension());

            $saveData['image'] = $file->storeAs('uploads', $filename, 'public');
        }else {
            $saveData['image'] = 'uploads/default.png';
        }
        $student = Student::create($saveData);

        return redirect()->route('students.show', $student->id)
            ->with('success', __('messages.student_created_successfully'));
    }

    public function show($id)
    {
        $student = Student::withTrashed()->findOrFail($id);
        $courses = $student->courses()->paginate(10);
        $coursesCount = $student->courses()->count();
        return view('students.view', compact('student', 'courses', 'coursesCount'));
    }

    public function enrollmentSearch(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['error' => __('messages.invalid_request')], 400);
        }

        $searchTerm = trim($request->input('search'));
        $searchBy = $request->input('search_by', 'all');
        $studentId = $request->input('student_id');

        if (!$studentId) {
            return response()->json(['error' => __('messages.student_id_missing')], 400);
        }

        $student = Student::withTrashed()->findOrFail($studentId);

        $query = $student->courses();

        if ($searchTerm !== '') {
            $query->where(function ($q) use ($searchTerm, $searchBy) {

                if ($searchBy === 'id') {
                    $q->where('courses.id', 'LIKE', "%{$searchTerm}%");
                } elseif ($searchBy === 'title') {
                    $q->where('courses.title', 'LIKE', "%{$searchTerm}%");
                } elseif ($searchBy === 'status') {
                    $q->where('bookings.status', 'LIKE', "%{$searchTerm}%");
                } else { // all
                    $q->where('courses.title', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('courses.id', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('bookings.status', 'LIKE', "%{$searchTerm}%");
                }
            });
        }

        $paginator = $query->paginate(10);

        return response()->json([
            'html' => view('students.partials.enrollment_courses_table', [
                'courses' => $paginator,
                'searchTerm' => $searchTerm
            ])->render(),
            'pagination' => (string) $paginator->links(),
            'count' => $paginator->total(),
        ]);
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $countries = Country::all();
        return view('students.edit', compact('student', 'countries'));
    }

    public function update(EditStudentRequest $request, $id)
    {
        $student = Student::findOrFail($id);

        $updateData = $request->validated();
        $updateData['updated_at'] = now();

        if ($request->hasFile('image')) {
            // احفظ مسار القديمة
            $oldImage = $student->image;

            $file = $request->file('image');
            $filename = Str::uuid() . '.' . strtolower($file->getClientOriginalExtension());

            // خزّن الجديدة
            $newPath = $file->storeAs('uploads', $filename, 'public');
            $updateData['image'] = $newPath;

            // احذف القديمة بعد نجاح التخزين
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
        }


        $student->update($updateData);

        return redirect()->route('students.show', $student->id)
            ->with('success', __('messages.student_updated_successfully'));
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return redirect()->route('students.index')
            ->with('success', __('messages.student_deleted_successfully'));
    }

    public function recycle()
    {
        $students = Student::onlyTrashed()->paginate(10);
        $studentsCount = Student::onlyTrashed()->count();
        return view('students.recycle', compact('students', 'studentsCount'));
    }

    public function recycleSearch(Request $request)
    {
        if ($request->ajax()) {
            $searchTerm = $request->input('search');
            $searchBy = $request->input('search_by');

            $query = Student::onlyTrashed();

            if ($searchTerm) {
                if ($searchBy === 'name') {
                    $query->where('name', 'LIKE', "%{$searchTerm}%");
                } elseif ($searchBy === 'id') {
                    $query->where('id', 'LIKE', "%{$searchTerm}%");
                } elseif ($searchBy === 'status') {
                    $query->where('status', 'LIKE', "%{$searchTerm}%");
                } else {
                    $query->where(function ($q) use ($searchTerm) {
                        $q->where('name', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('status', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('id', 'LIKE', "%{$searchTerm}%");
                    });
                }
            }

            $students = $query->paginate(10);

            return response()->json([
                'html' => view('students.partials.recycle_table', [
                    'students' => $students,
                    'searchTerm' => $searchTerm,
                ])->render(),
                'pagination' => (string) $students->links(),
                'count' => $students->total(),
            ]);
        }

        return response()->json(['error' => __('messages.invalid_request')], 400);
    }

    public function restore($id)
    {
        $student = Student::onlyTrashed()->findOrFail($id);
        $student->restore();
        return redirect()->route('students.show', $student->id)
            ->with('success', __('messages.student_restored_successfully'));
    }

    public function deletePermanently($id)
    {
        $student = Student::onlyTrashed()->findOrFail($id);
        if ($student->image && Storage::disk('public')->exists($student->image) && $student->image !== 'uploads/default.png') {
            Storage::disk('public')->delete($student->image);
        }
        $student->forceDelete();

        return redirect()->route('students.recycle')
            ->with('success', __('messages.student_permanently_deleted'));
    }
}
