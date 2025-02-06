@extends('voyager::master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Grammer</div>

                    <div class="panel-body">
                        <form action="{{ route('grammers.update', $grammer->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="filter_course">Course</label>
                                <select class="form-control select2" id="filter_course" name="course_id">
                                    <option value="">All</option>
                                    <option value="A1" {{ $grammer->course_id == 'A1' ? 'selected' : '' }}>A1</option>
                                    <option value="A2" {{ $grammer->course_id == 'A2' ? 'selected' : '' }}>A2</option>
                                    <option value="A3" {{ $grammer->course_id == 'A3' ? 'selected' : '' }}>A3</option>
                                    <option value="B1" {{ $grammer->course_id == 'B1' ? 'selected' : '' }}>B1</option>
                                    <option value="B2" {{ $grammer->course_id == 'B2' ? 'selected' : '' }}>B2</option>
                                    <option value="B3" {{ $grammer->course_id == 'B3' ? 'selected' : '' }}>B3</option>
                                    <option value="C1" {{ $grammer->course_id == 'C1' ? 'selected' : '' }}>C1</option>
                                    <option value="C2" {{ $grammer->course_id == 'C2' ? 'selected' : '' }}>C2</option>
                                    <option value="C3" {{ $grammer->course_id == 'C3' ? 'selected' : '' }}>C3</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="text">Text</label>
                                <textarea name="text" id="text" class="form-control" rows="3">{{ $grammer->text }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Grammer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
