@foreach ($students as $student)
    <tr>
        <td>{!! highlight($student->id, $searchTerm) !!}</td>
        <td>
            @if ($student->image)
                <a href="{{ asset('storage/' . $student->image) }}" data-toggle="lightbox"
                    data-title="Student Image - {{ $student->id }}">
                    <img src="{{ asset('storage/' . $student->image) }}" alt="Student Image" class="img-thumbnail" width="50"
                        height="50">
                </a>
            @else
                <span>No Image</span>
            @endif
        </td>
        <td>{!! highlight($student->name, $searchTerm) !!}</td>
        <td>{!! highlight($student->status, $searchTerm) !!}</td>
        <td>
            <div class="btn-group-responsive">
                <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-primary"><i
                        class="fas fa-eye"></i> View</a>
                <a href="{{ route('students.restore', $student->id) }}" class="btn btn-sm btn-success"><i
                        class="fas fa-undo"></i> Restore</a>
                <a href="{{ route('students.delete-permanently', $student->id) }}" class="btn btn-sm btn-danger"><i
                        class="fas fa-trash"></i> Permanent
                    deletion</a>
            </div>
        </td>
    </tr>
@endforeach