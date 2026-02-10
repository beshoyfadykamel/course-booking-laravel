<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditBookingRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('student', 'course')->paginate(10);
        $bookings_count = Booking::with('student', 'course')->count();
        $recycleCount = Booking::onlyTrashed()->count();
        return view('bookings.index', compact('bookings', 'bookings_count', 'recycleCount'));
    }


    public function search(Request $request)
    {
        if ($request->ajax()) {
            $searchTerm = $request->input('search');
            $searchBy = $request->input('search_by');

            $query = Booking::query();

            if ($searchTerm !== '') {
                $query->where(function ($main) use ($searchTerm, $searchBy) {
                    if ($searchBy === 'student_name') {
                        $main->whereHas('student', function ($q) use ($searchTerm) {
                            $q->where('students.name', 'LIKE', "%{$searchTerm}%");
                        });
                    } elseif ($searchBy === 'course_name') {
                        $main->whereHas('course', function ($q) use ($searchTerm) {
                            $q->where('courses.title', 'LIKE', "%{$searchTerm}%");
                        });
                    } elseif ($searchBy === 'id') {
                        if (is_numeric($searchTerm)) {
                            $main->where('id', (int) $searchTerm);
                        } else {
                            $main->where('id', 'LIKE', "%{$searchTerm}%");
                        }
                    } elseif ($searchBy === 'status') {
                        $main->where('status', 'LIKE', "%{$searchTerm}%");
                    } else { // all
                        $main->where(function ($q) use ($searchTerm) {
                            $q->where('id', 'LIKE', "%{$searchTerm}%")
                                ->orWhereHas('student', function ($s) use ($searchTerm) {
                                    $s->where('students.name', 'LIKE', "%{$searchTerm}%");
                                })
                                ->orWhereHas('course', function ($c) use ($searchTerm) {
                                    $c->where('courses.title', 'LIKE', "%{$searchTerm}%");
                                });
                        });
                    }
                });
            }

            $bookings = $query->paginate(10);

            return response()->json([
                'html' => view('bookings.partials.bookings_table', compact('bookings', 'searchTerm'))->render(),
                'pagination' => (string) $bookings->links(),
                'count' => $bookings->total()
            ]);
        }

        return response()->json(['error' => __('messages.invalid_request')], 400);
    }

    public function create()
    {
        $students = Student::all();
        $courses = Course::all();
        return view('bookings.create', compact('students', 'courses'));
    }

    public function store(StoreBookingRequest $request)
    {


        $booking = Booking::create($request->validated());

        return redirect()->route('bookings.show', $booking->id)
            ->with('success', __('messages.booking_created_successfully'));
    }

    public function show($id)
    {
        $booking = Booking::with('student', 'course')->withTrashed()->findOrFail($id);
        return view('bookings.view', compact('booking'));
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        $students = Student::all();
        $courses = Course::all();
        return view('bookings.edit', compact('booking', 'students', 'courses'));
    }

    public function update(EditBookingRequest $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update($request->validated());
        $booking->updated_at = now();
        $booking->save();
        return redirect()->route('bookings.show', $booking->id)
            ->with('success', __('messages.booking_updated_successfully'));
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();
        return redirect()->route('bookings.index')
            ->with('success', __('messages.booking_deleted_successfully'));
    }



    public function recycle()
    {
        $bookings = Booking::onlyTrashed()->with('student', 'course')->paginate(10);
        $bookings_count = Booking::onlyTrashed()->count();
        return view('bookings.recycle', compact('bookings', 'bookings_count'));
    }

    public function recycleSearch(Request $request)
    {
        if ($request->ajax()) {
            $searchTerm = $request->input('search');
            $searchBy = $request->input('search_by'); // Not really used in recycle view based on previous examples, but good to have

            $query = Booking::with('student', 'course')->onlyTrashed();

            if ($searchTerm !== '') {
                $query->where(function ($main) use ($searchTerm, $searchBy) {
                    if ($searchBy === 'student_name') {
                        $main->whereHas('student', function ($q) use ($searchTerm) {
                            $q->where('students.name', 'LIKE', "%{$searchTerm}%");
                        });
                    } elseif ($searchBy === 'course_name') {
                        $main->whereHas('course', function ($q) use ($searchTerm) {
                            $q->where('courses.title', 'LIKE', "%{$searchTerm}%");
                        });
                    } elseif ($searchBy === 'id') {
                        if (is_numeric($searchTerm)) {
                            $main->where('id', (int) $searchTerm);
                        } else {
                            $main->where('id', 'LIKE', "%{$searchTerm}%");
                        }
                    } elseif ($searchBy === 'status') {
                        $main->where('status', 'LIKE', "%{$searchTerm}%");
                    } else { // all
                        $main->where(function ($q) use ($searchTerm) {
                            $q->where('id', 'LIKE', "%{$searchTerm}%")
                                ->orWhereHas('student', function ($s) use ($searchTerm) {
                                    $s->where('students.name', 'LIKE', "%{$searchTerm}%");
                                })
                                ->orWhereHas('course', function ($c) use ($searchTerm) {
                                    $c->where('courses.title', 'LIKE', "%{$searchTerm}%");
                                });
                        });
                    }
                });
            }
            $bookings = $query->paginate(10);

            return response()->json([
                'html' => view('bookings.partials.recycle_table', compact('bookings', 'searchTerm'))->render(),
                'pagination' => (string) $bookings->links(),
                'count' => $bookings->total()
            ]);
        }

        return response()->json(['error' => __('messages.invalid_request')], 400);
    }

    public function restore($id)
    {
        $booking = Booking::onlyTrashed()->findOrFail($id);
        $booking->restore();
        return redirect()->route('bookings.show', $booking->id)
            ->with('success', __('messages.booking_restored_successfully'));
    }

    public function deletePermanently($id)
    {
        $booking = Booking::onlyTrashed()->findOrFail($id);
        $booking->forceDelete();
        return redirect()->route('bookings.recycle')
            ->with('success', __('messages.booking_permanently_deleted'));
    }
}
