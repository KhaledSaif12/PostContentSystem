@extends('layout.master')

@section('content')
<div class="container">
    <h1>Create New Post</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Enter post title" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" id="content" class="form-control" placeholder="Enter post content" required>{{ old('content') }}</textarea>
        </div>

        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="media_files">Media Files (images, videos, audio)</label>
            <input type="file" name="media_files[]" id="media_files" class="form-control" multiple>
            <small class="form-text text-muted">Allowed file types: jpg, jpeg, png, mp4, mp3. Max size: 10MB per file.</small>
        </div>

        <button type="submit" class="btn btn-success">Create Post</button>
    </form>
</div>
@endsection
