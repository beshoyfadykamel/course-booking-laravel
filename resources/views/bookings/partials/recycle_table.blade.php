@foreach ($bookings as $booking)
    <tr>
        <td>{!! highlight($booking->id, $searchTerm) !!}</td>
        <td>
            @if ($booking->course)
                <a href="{{ route('courses.show', $booking->course->id) }}">{!! highlight($booking->course->title, $searchTerm) !!}</a>
            @else
                <span class="text-danger">Course Deleted</span>
            @endif
        </td>
        <td>
            @if ($booking->student)
                <a href="{{ route('students.show', $booking->student->id) }}">{!! highlight($booking->student->name, $searchTerm) !!}</a>
            @else
                <span class="text-danger">Student Deleted</span>
            @endif
        </td>
        <td>{!! highlight($booking->status, $searchTerm) !!}</td>
        <td>
            <div class="btn-group-responsive">
                <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-primary"><i
                        class="fas fa-eye"></i> View</a>
                <a href="{{ route('bookings.restore', $booking->id) }}" class="btn btn-sm btn-success"><i
                        class="fas fa-undo"></i> Restore</a>
                <a href="{{ route('bookings.delete-permanently', $booking->id) }}" class="btn btn-sm btn-danger"><i
                        class="fas fa-trash"></i> Permanent
                    deletion</a>
            </div>
        </td>
    </tr>
@endforeach
