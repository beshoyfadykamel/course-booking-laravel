@foreach ($bookings as $booking)
    <tr>
        <td>{!! highlight($booking->id, $searchTerm) !!}</td>
        <td>
            @if ($booking->course)
                <a
                    href="{{ route('courses.show', $booking->course->id) }}">{!! highlight($booking->course->title, $searchTerm) !!}</a>
            @else
                <span class="text-danger">Course Deleted</span>
            @endif
        </td>
        <td>
            @if ($booking->student)
                <a
                    href="{{ route('students.show', $booking->student->id) }}">{!! highlight($booking->student->name, $searchTerm) !!}</a>
            @else
                <span class="text-danger">Student Deleted</span>
            @endif
        </td>
        <td>{!! highlight($booking->status, $searchTerm) !!}</td>
        <td>
            <div class="btn-group-responsive">
                <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-primary"><i
                        class="fas fa-eye"></i> View</a>
                <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-sm btn-warning"><i
                        class="fas fa-pencil-alt"></i> Edit</a>
                <a href="{{ route('bookings.destroy', $booking->id) }}" class="btn btn-sm btn-danger"><i
                        class="fas fa-trash"></i> Delete</a>
            </div>
        </td>
    </tr>
@endforeach