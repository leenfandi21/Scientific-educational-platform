@extends('voyager::master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add New Post</div>

                <div class="card-body">
                    <form action="{{ route('news_post.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <textarea class="form-control form-control-lg" name="description" id="description" rows="5" placeholder="What's on your mind?" style="color: black;"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="images" class="btn btn-primary">Add Photos</label>
                            <input type="file" class="form-control-file" name="images[]" id="images" multiple style="display: none;">
                        </div>
                        <button type="submit" class="btn btn-primary">Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Posts</div>

                <div class="card-body">
                    @if ($posts->isEmpty())
                        <p>No posts found.</p>
                    @else
                        @foreach ($posts as $post)
                            <div class="card mb-4">
                                <div class="card-body">
                                    <p class="card-text" style="font-size: 18px; color: black;">{{ $post->description }}</p>
                                </div>
                                <div class="card-footer">
                                    @foreach ($post->images as $image)
                                        <img src="{{ url($image->image_path) }}" class="post-image" alt="Post Image">
                                    @endforeach
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('news_post.edit', ['news_post' => $post->id]) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('news_post.destroy', ['news_post' => $post->id]) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
