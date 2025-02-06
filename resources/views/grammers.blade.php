@extends('voyager::master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Add New Grammer</div>

                    <div class="panel-body">
                        <form action="{{ route('grammers.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="filter_course">Course</label>
                                <select class="form-control select2" id="filter_course" name="course_id">
                                    <option value="">All</option>
                                    <option value="A1">A1</option>
                                    <option value="A2">A2</option>
                                    <option value="A3">A3</option>
                                    <option value="B1">B1</option>
                                    <option value="B2">B2</option>
                                    <option value="B3">B3</option>
                                    <option value="C1">C1</option>
                                    <option value="C2">C2</option>
                                    <option value="C3">C3</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="text">Text</label>
                                <textarea name="text" id="text" class="form-control" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Grammer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Grammers List</div>

                    <div class="panel-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Course</th>
                                    <th>Text</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($grammers as $grammer)
                                    <tr>
                                        <td>{{ $grammer->id }}</td>
                                        <td>{{ $grammer->course->course_name }}</td>
                                        <td>{{ $grammer->text }}</td>

                                        <td>
                                            <a href="{{ route('grammers.edit', $grammer->id) }}" class="btn btn-primary">Edit</a>
                                            <form action="{{ route('grammers.destroy', $grammer->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this grammer?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
