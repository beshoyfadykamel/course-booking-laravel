@foreach ($courses as $course)
    <tr>
        <td>{!! highlight($course->id, $searchTerm) !!}</td>
        <td>{!! highlight($course->title, $searchTerm) !!}</td>
        <td>{!! highlight($course->pivot->status, $searchTerm) !!}</td>
        <td>
            <div class="btn-group-responsive">
                <a href="{{ route('courses.show', $course->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i>
                    View
                    Course</a>
            </div>
        </td>
    </tr>
@endforeach