@foreach ($students as $student)
    <tr>
        <td>{!! highlight($student->id, $searchTerm) !!}</td>
        <td>
            @if ($student->image)
                <a href="{{ asset('storage/' . $student->image) }}" data-toggle="lightbox"
                    data-title="{{ $student->name }} - {{ $student->id }}">
                    <img src="{{ asset('storage/' . $student->image) }}" alt="{{ __('messages.student_image') }}" class="img-thumbnail" width="50"
                        height="50">
                </a>
            @else
                <span>{{ __('messages.no_image') }}</span>
            @endif
        </td>
        <td>{!! highlight($student->name, $searchTerm) !!}</td>
        <td>{!! highlight($student->status, $searchTerm) !!}</td>
        <td>
            <div class="btn-group-responsive">
                <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-primary"><i
                        class="fas fa-eye"></i> {{ __('messages.view') }}</a>
                <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-warning"><i
                        class="fas fa-pencil-alt"></i> {{ __('messages.edit') }}</a>
                <a href="{{ route('students.destroy', $student->id) }}" class="btn btn-sm btn-danger"><i
                        class="fas fa-trash"></i> {{ __('messages.delete') }}</a>
            </div>
        </td>
    </tr>
@endforeach