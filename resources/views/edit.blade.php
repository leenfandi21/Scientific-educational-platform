@extends('voyager::master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Post</div>

                <div class="card-body">
                    <form action="{{ route('news_post.update', ['news_post' => $news_post->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <textarea class="form-control form-control-lg" name="description" id="description" rows="5" placeholder="What's on your mind?" style="color: black;">{{ $news_post->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="images" class="btn btn-primary">Add Photos</label>
                            <input type="file" class="form-control-file" name="images[]" id="images" multiple style="display: none;">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
