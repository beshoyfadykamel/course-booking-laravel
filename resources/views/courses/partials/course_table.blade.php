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
                <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-warning"><i
                        class="fas fa-pencil-alt"></i> {{ __('messages.edit') }}</a>
                <a href="{{ route('courses.destroy', $course->id) }}" class="btn btn-sm btn-danger"><i
                        class="fas fa-trash"></i> {{ __('messages.delete') }}</a>
            </div>
        </td>
    </tr>
@endforeach