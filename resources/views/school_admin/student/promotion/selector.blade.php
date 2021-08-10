<hr />
<div class="card">
    <div class="card-header text-center">
        <strong>Students Of Class {{ $class->name }}</strong>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered">
            <thead>
                <th>Name</th>
                <th>Section</th>
                <th>Roll</th>
                <th>Options</th>
            </thead>
            <tbody>
                @foreach($enrolls as $row)
                    <tr>
                        <td>{{ $row->student->user->name }}</td>
                        <td>{{ $row->section->name  }}</td>
                        <td>{{ $row->roll_number }}</td>
                        <td>
                            <input type="hidden" value="{{ $row->id }}" name="enroll_ids[]">
                            <input type="hidden" value="{{ $row->section->name }}" name="section_ids[]">
                            <select class="form-control" name="class_ids[]">
                                <option value="{{ $to_class_id }}">Enroll To Class - {{ $to_class->name }}</option>
                                <option value="{{ $from_class_id }}">Enroll To Class - {{ $class->name }}</option>
                            </select>
                        </td>
                    </tr>
                @endforeach
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-primary-link">Promote Selected Students</button>
                </div>
            </tbody>
        </table>
    </div>
</div>