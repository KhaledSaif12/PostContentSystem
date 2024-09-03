@extends('layout.master')
@section('content')

<div class="container">
    <h1>Edit Media File</h1>

    <form action="{{ route('mediafiles.update', $mediaFile->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="post_id">Post</label>
            <select name="post_id" id="post_id" class="form-control" required>
                <option value="">Select a Post</option>
                @foreach($posts as $post)
                    <option value="{{ $post->id }}" {{ $mediaFile->post_id == $post->id ? 'selected' : '' }}>
                        {{ $post->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="file_path">File Path</label>
            <input type="text" id="file_path" name="file_path" class="form-control" value="{{ $mediaFile->file_path }}" readonly>
        </div>

        <div class="form-group">
            <label for="file_type">File Type</label>
            <input type="text" id="file_type" name="file_type" class="form-control" value="{{ $mediaFile->file_type }}" readonly>
        </div>

        <button type="submit" class="btn btn-primary">Update Media File</button>
        <a href="{{ route('mediafiles.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

@endsection
