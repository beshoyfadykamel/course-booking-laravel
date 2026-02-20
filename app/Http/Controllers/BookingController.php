<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditBookingRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Booking::class);
        $bookings = Booking::with('student', 'course', 'user')->forCurrentUser()->paginate(10);
        $bookings_count = Booking::forCurrentUser()->count();
        $recycleCount = Booking::onlyTrashed()->forCurrentUser()->count();
        return view('bookings.index', compact('bookings', 'bookings_count', 'recycleCount'));
    }


    public function search(Request $request)
    {
        if ($request->ajax()) {
            $this->authorize('viewAny', Booking::class);
            $searchTerm = $request->input('search');
            $searchBy = $request->input('search_by');

            $query = Booking::query()->forCurrentUser();

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

            $bookings = $query->with('user')->paginate(10);

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
        $this->authorize('create', Booking::class);
        $students = Student::where('user_id', Auth::id())->get();
        $courses = Course::where('user_id', Auth::id())->get();
        return view('bookings.create', compact('students', 'courses'));
    }

    public function store(StoreBookingRequest $request)
    {
        $this->authorize('create', Booking::class);
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        [$booking, $wasRestored] = DB::transaction(function () use ($data) {

            $existing = Booking::withTrashed()
                ->where('student_id', $data['student_id'])
                ->where('course_id', $data['course_id'])
                ->first();

            if ($existing && $existing->trashed()) {
                $existing->restore();
                $existing->update([
                    'status' => $data['status'],
                ]);

                return [$existing, true];  
            }

            if (! $existing) {
                return [Booking::create($data), false]; 
            }

            return [$existing, false];
        });

        $messageKey = $wasRestored
            ? 'messages.booking_restored_successfully'
            : 'messages.booking_created_successfully';

        return redirect()
            ->to(roleRoute('bookings.show', $booking->id))
            ->with('success', __($messageKey));
    }


    public function show($id)
    {
        $booking = Booking::with('student', 'course', 'user')->withTrashed()->forCurrentUser()->findOrFail($id);
        $this->authorize('view', $booking);
        return view('bookings.view', compact('booking'));
    }

    public function edit($id)
    {
        $booking = Booking::forCurrentUser()->findOrFail($id);
        $this->authorize('update', $booking);
        $students = Student::where('user_id', $booking->user_id)->get();
        $courses = Course::where('user_id', $booking->user_id)->get();
        return view('bookings.edit', compact('booking', 'students', 'courses'));
    }

    public function update(EditBookingRequest $request, $id)
    {
        $booking = Booking::forCurrentUser()->findOrFail($id);
        $this->authorize('update', $booking);
        $booking->update($request->validated());
        $booking->updated_at = now();
        $booking->save();
        return redirect()->to(roleRoute('bookings.show', $booking->id))
            ->with('success', __('messages.booking_updated_successfully'));
    }

    public function destroy($id)
    {
        $booking = Booking::forCurrentUser()->findOrFail($id);
        $this->authorize('delete', $booking);
        $booking->delete();
        return redirect()->to(roleRoute('bookings.index'))
            ->with('success', __('messages.booking_deleted_successfully'));
    }



    public function recycle()
    {
        $this->authorize('viewAny', Booking::class);
        $bookings = Booking::onlyTrashed()->forCurrentUser()->with('student', 'course', 'user')->paginate(10);
        $bookings_count = Booking::onlyTrashed()->forCurrentUser()->count();
        return view('bookings.recycle', compact('bookings', 'bookings_count'));
    }

    public function recycleSearch(Request $request)
    {
        if ($request->ajax()) {
            $this->authorize('viewAny', Booking::class);
            $searchTerm = $request->input('search');
            $searchBy = $request->input('search_by'); // Not really used in recycle view based on previous examples, but good to have

            $query = Booking::with('student', 'course', 'user')->onlyTrashed()->forCurrentUser();

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
        $booking = Booking::onlyTrashed()->forCurrentUser()->findOrFail($id);
        $this->authorize('restore', $booking);
        $booking->restore();
        return redirect()->to(roleRoute('bookings.show', $booking->id))
            ->with('success', __('messages.booking_restored_successfully'));
    }

    public function deletePermanently($id)
    {
        $booking = Booking::onlyTrashed()->forCurrentUser()->findOrFail($id);
        $this->authorize('forceDelete', $booking);
        $booking->forceDelete();
        return redirect()->to(roleRoute('bookings.recycle'))
            ->with('success', __('messages.booking_permanently_deleted'));
    }
}
