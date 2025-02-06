@extends('voyager::master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Upload File</div>

                <div class="panel-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <head>
                        <title>Upload PDF and Voice Files</title>
                    </head>
                    <body>
                        <form action="{{ route('uploadCourse') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="course">Course:</label>
                                <select class="form-control select2" id="course" name="course">
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
                                <label for="pdf_file">Select PDF File:</label>
                                <input type="file" id="pdf_file" name="pdf_file" accept=".pdf">
                            </div>

                            <div class="form-group">
                                <label for="voice_file">Select Voice File:</label>
                                <input type="file" id="voice_file" name="voice_file" accept="audio/*">
                            </div>

                            <button type="submit" class="btn btn-primary">Upload Files</button>
                        </form>
                    </body>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Files List</div>

                <div class="panel-body">
                    <label for="filter_course">Filter by Course:</label>
                    <select class="form-control select2" id="filter_course" name="filter_course">
                        <option value="all">All</option>
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

                    <table class="table">
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>Course</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="file_list">
                            <!-- Files will be dynamically loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    // Fetch files based on selected course
    $('#filter_course').on('change', function() {
        var courseId = $(this).val();
        fetchFiles(courseId);
    });

    // Initial loading of files on page load
    var initialCourseId = $('#filter_course').val();
    fetchFiles(initialCourseId);
});

// ...

function fetchFiles(courseId) {
    $.ajax({
        url: '{{ route("getFiles") }}',
        type: 'GET',
        data: {
            course_id: courseId
        },
        success: function(response) {
            // Clear previous files
            $('#file_list').empty();

            // Append new files
            $.each(response.files, function(index, file) {

                var row = '<tr>' +
                    '<td>' + file.file_name + '</td>' +
                    '<td>' + file.course + '</td>' +
                    '<td>' + file.type + '</td>' +
                    '<td>' +
                    '<button class="btn btn-danger btn-sm" onclick="deleteFile(' + file.id + ')">Delete</button>' +
                    '</td>' +
                    '</tr>';
                $('#file_list').append(row);
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

function deleteFile(fileId) {
    $.ajax({
        url: '{{ route("deleteFile") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            file_id: fileId
        },
        success: function(response) {
            // File deleted successfully, update the file list
            var courseId = $('#filter_course').val();
            fetchFiles(courseId);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });

}
</script>

@endsection
