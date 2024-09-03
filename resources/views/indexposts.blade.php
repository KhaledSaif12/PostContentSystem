@extends('layout.master')

@section('content')
<div class="container-fluid pt-5 mb-3">

    <div class="container">
        <h1 class="mb-4">All Posts</h1>
        <a href="{{ route('posts.create') }}" class="btn btn-success mb-4">Create New Post</a>

        @if($posts->isEmpty())
            <div class="alert alert-info">No posts available.</div>
        @else
            <div class="post-grid">
                @foreach($posts as $post)
                    <div class="post-card">
                        @foreach($post->mediaFiles as $media)
                            @if($media->file_type === 'image')
                                <img class="img-fluid w-100" src="{{ asset('storage/' . $media->file_path) }}" style="object-fit: cover;" alt="Image">
                            @elseif($media->file_type === 'video')
                                <video controls class="w-100" style="object-fit: cover;">
                                    <source src="{{ asset('storage/' . $media->file_path) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @elseif($media->file_type === 'audio')
                                <audio controls class="w-100">
                                    <source src="{{ asset('storage/' . $media->file_path) }}" type="audio/mp3">
                                    Your browser does not support the audio element.
                                </audio>
                            @else
                                <a href="{{ asset('storage/' . $media->file_path) }}" target="_blank" class="btn btn-link">Download {{ ucfirst($media->file_type) }}</a>
                            @endif
                        @endforeach
                        <div class="p-4 bg-dark text-white">
                            <h2 class="font-weight-bold mb-2">{{ $post->title }}</h2>
                            <p><strong>Category:</strong> {{ $post->category->name }}</p>
                            <p><strong>Author:</strong> {{ $post->user->name }}</p>
                            <p>{{ $post->content }}</p>
                            <div class="actions mt-3">
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

<style>
    .post-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1rem;
    }

    .post-card {
        border-radius: .25rem;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075);
    }
</style>
