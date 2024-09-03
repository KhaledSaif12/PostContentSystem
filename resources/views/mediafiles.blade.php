@extends('layout.master')
@section('content')

<div class="container">
    <h1>Media Files</h1>

    <a href="{{ route('mediafiles.create') }}" class="btn btn-primary mb-3">Upload New Media</a>

    @if($mediaFiles->isEmpty())
        <p>No media files available.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Post Title</th>
                    <th>File Path</th>
                    <th>File Type</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mediaFiles as $mediaFile)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $mediaFile->post ? $mediaFile->post->title : 'N/A' }}</td>
                        <td>
                            <a href="{{ asset('storage/' . $mediaFile->file_path) }}" target="_blank">
                                {{ basename($mediaFile->file_path) }}
                            </a>
                        </td>
                        <td>{{ $mediaFile->file_type }}</td>
                        <td>{{ $mediaFile->created_at->format('Y-m-d H:i:s') }}</td>
                        <td>
                            <a href="{{ route('mediafiles.edit', $mediaFile->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('mediafiles.destroy', $mediaFile->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Links -->
        {{ $mediaFiles->links() }}
    @endif
</div>

@endsection
