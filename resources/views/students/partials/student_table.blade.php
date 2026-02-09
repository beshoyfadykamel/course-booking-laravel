
                            @foreach ($students as $student)
                                <tr>
                                    <td>{!! highlight($student->id, $searchTerm) !!}</td>
                                    <td>
                                        @if ($student->image)
                                            <a href="{{ asset('storage/' . $student->image) }}" data-toggle="lightbox"
                                                data-title="Student Image - {{ $student->id }}">
                                                <img src="{{ asset('storage/' . $student->image) }}" alt="Student Image"
                                                    class="img-thumbnail" width="50" height="50">
                                            </a>
                                        @else
                                            <span>No Image</span>
                                        @endif
                                    </td>
                                    <td>{!! highlight($student->name, $searchTerm) !!}</td>
                                    <td>{!! highlight($student->status, $searchTerm) !!}</td>
                                    <td>
                                        <div class="btn-group-responsive">
                                            <a href="{{ route('students.show', $student->id) }}"
                                                class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> View</a>
                                            <a href="{{ route('students.edit', $student->id) }}"
                                                class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i> Edit</a>
                                            <a href="{{ route('students.destroy', $student->id) }}"
                                                class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
