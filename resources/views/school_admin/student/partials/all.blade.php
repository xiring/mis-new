<div class="card-body table-responsive">
    <table class="table table-striped" width="100%" id="datatable">
        <thead>
            <th>S.N</th>
            <th>Roll</th>
            <th>Section</th>
            <th>Name</th>
            <th>Address</th>
            <th>House</th>
            <th>Date Of Admission</th>
            <th>Status</th>
            <th>Options</th>
        </thead>
        <tbody>
            @php $n = 0 @endphp
            @foreach($enrolls as $enroll)
                <tr>
                    <td>{{ ++$n }}</td>
                    <td>{{ $enroll->roll_number }}</td>
                    <td>{{ $enroll->section->name }}</td>
                    <td>{{ $enroll->student->user->name }}</td>
                    <td>{{ $enroll->student->address }}</td>
                    <td>{{ $enroll->student->house }}</td>
                    <td>{{ Carbon\Carbon::parse($enroll->created_at)->format('Y-m-d') }}</td>
                    <td>
                        <?=($enroll->student->user->is_active == 0)?
                            '<span class="badge badge-danger">Deleted</span>'
                            :
                            '<span class="badge badge-success">Active</span>'
                        ;?>
                    </td>
                    <td>
                        <div class="dropdown">
                            <a class="btn btn-sm btn-rounded btn-outline-primary dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Options
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                @if($enroll->student->user->is_active == 1)
                                    <a href="" data-toggle="modal" data-target="#editStudent" data-date="{{ \Carbon\Carbon::parse($enroll->student->date_of_birth)->format('Y-m-d')  }}" data-religion="{{ $enroll->student->religion }}" data-gender="{{ $enroll->student->gender }}" data-id="{{ $enroll->id }}" data-roll="{{ $enroll->roll_number }}" data-name="{{ $enroll->student->user->name }}" data-address="{{ $enroll->student->address }}" data-email="{{ $enroll->student->user->email }}" data-class="{{ $enroll->class_id }}" data-section="{{ $enroll->section_id }}" data-parent="{{ $enroll->student->parent_id }}" data-transport="{{ $enroll->student->transport_id }}"  data-house="{{ $enroll->student->house }}" class="dropdown-item">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="{{ route('student.view', $enroll->id) }}" class="dropdown-item">View</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="" data-toggle="modal" data-target="#scholarshipStudent" data-id="{{ $enroll->student->id }}" data-scholarship="{{ $enroll->student->scholarship_id }}" class="dropdown-item">Assign Scholarship</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="{{ route('student.delete', $enroll->student->user->id) }}" class="dropdown-item">Delete</a>
                                    @if($enroll->is_active == 1)
                                        <div class="dropdown-divider"></div>
                                        <a href="{{ route('student.mark.left', $enroll->id) }}" class="dropdown-item">Mark Left</a>
                                    @endif
                                    <div class="dropdown-divider"></div>
                                    <a href="{{ route('student.demote', $enroll->id) }}" class="dropdown-item">Demote</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="{{ route('student.jump', $enroll->id) }}" class="dropdown-item">Jump To Another Class</a>
                                @else
                                    <a href="{{ route('student.restore', $enroll->student->user->id) }}" class="dropdown-item">Restore</a>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

