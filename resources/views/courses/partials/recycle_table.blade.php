@foreach ($courses as $course)
    <tr>
        <td>{!! highlight($course->id, $searchTerm) !!}</td>
        <td>
            {!! highlight($course->title, $searchTerm) !!}
        </td>
        <td>
            {!! highlight($course->status, $searchTerm) !!}
        </td>
        <td>
            <div class="btn-group-responsive">
                <a href="{{ route('courses.show', $course->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i>
                    {{ __('messages.view') }}</a>
                <a href="{{ route('courses.restore', $course->id) }}" class="btn btn-sm btn-success"><i
                        class="fas fa-undo"></i> {{ __('messages.restore') }}</a>
                <a href="{{ route('courses.delete-permanently', $course->id) }}" class="btn btn-sm btn-danger"><i
                        class="fas fa-trash"></i> {{ __('messages.permanent_deletion') }}</a>
            </div>
        </td>
    </tr>
@endforeach