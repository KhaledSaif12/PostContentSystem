<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MediaFile;
use App\Models\Post; // Assuming you have a Post model
use Illuminate\Support\Facades\Storage; // Import the Storage facade

class MediaFileController extends Controller
{
    //
    public function index()
    {
        $mediaFiles = MediaFile::with('post')->paginate(10); // Paginate results
        return view('mediafiles.index', compact('mediaFiles'));
    }

    public function create()
    {
        $posts = Post::all(); // Fetch all posts for the select field
        return view('mediafiles.create', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,mp3|max:20480', // Adjust as needed
        ]);

        $file = $request->file('file');
        $filePath = $file->store('media', 'public');

        MediaFile::create([
            'post_id' => $request->post_id,
            'file_path' => $filePath,
            'file_type' => $file->getClientOriginalExtension(),
        ]);

        return redirect()->route('mediafiles.index')->with('success', 'Media file uploaded successfully.');
    }

    public function edit(MediaFile $mediaFile)
    {
        $posts = Post::all(); // Fetch all posts for the select field
        return view('mediafiles.edit', compact('mediaFile', 'posts'));
    }

    public function update(Request $request, MediaFile $mediaFile)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
        ]);

        $mediaFile->update([
            'post_id' => $request->post_id,
        ]);

        return redirect()->route('mediafiles.index')->with('success', 'Media file updated successfully.');
    }

    public function destroy(MediaFile $mediaFile)
    {
        // Delete the media file from storage
        Storage::disk('public')->delete($mediaFile->file_path);

        $mediaFile->delete();

        return redirect()->route('mediafiles.index')->with('success', 'Media file deleted successfully.');
    }
}
