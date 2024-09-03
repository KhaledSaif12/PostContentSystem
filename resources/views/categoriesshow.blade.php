@extends('layout.master')

@section('content')
<div class="container-fluid pt-5 mb-3">
    <div class="container">
        <h1>Posts in Category: {{ $category->name }}</h1>

        @if($category->posts->isEmpty())
            <div class="alert alert-info">No posts available for this category.</div>
        @else
            <div class="row">
                @foreach($category->posts as $post)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            @if($post->mediaFiles->isNotEmpty())
                                @foreach($post->mediaFiles as $media)
                                    @if($media->file_type === 'image')
                                        <img class="card-img-top" src="{{ asset('storage/' . $media->file_path) }}" alt="Image">
                                    @elseif($media->file_type === 'video')
                                        <video class="card-img-top" controls>
                                            <source src="{{ asset('storage/' . $media->file_path) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @elseif($media->file_type === 'audio')
                                        <audio class="card-img-top" controls>
                                            <source src="{{ asset('storage/' . $media->file_path) }}" type="audio/mp3">
                                            Your browser does not support the audio element.
                                        </audio>
                                    @endif
                                @endforeach
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $post->title }}</h5>
                                <p class="card-text">{{ Str::limit($post->content, 100) }}</p>
                                <p class="card-text"><small class="text-muted">Author: {{ $post->user->name }}</small></p>
                                <p class="card-text"><small class="text-muted">Date: {{ $post->created_at->format('M d, Y') }}</small></p>
                                <a href="{{ route('categories.show', $category->id) }}" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
