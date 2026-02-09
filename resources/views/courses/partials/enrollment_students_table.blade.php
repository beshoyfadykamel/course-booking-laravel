@foreach ($students as $student)
    <tr>
        <td>{!! highlight($student->id, $searchTerm) !!}</td>
        <td><img src="{{ asset('storage/' . $student->image) }}" alt="Student Image" class="img-thumbnail" width="50">
        </td>
        <td>
            {!! highlight($student->name, $searchTerm) !!}
        </td>
        <td>
            {!! highlight($student->pivot->status, $searchTerm) !!}
        </td>
        <td>
            <div class="btn-group-responsive">
                <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-primary"><i
                        class="fas fa-eye"></i> View Student</a>
            </div>
        </td>
    </tr>
@endforeach