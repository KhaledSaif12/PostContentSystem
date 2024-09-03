<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Storage; // Import the Storage facade
use Illuminate\Support\Facades\Auth;

use App\Models\Category; // Assuming you have a Category model
use App\Models\MediaFile; // Assuming you have a MediaFile model
class PostController extends Controller
{
    //
   // Index method to display all posts
   public function index()
   {
       $posts = Post::with(['user', 'category', 'mediaFiles'])->get();
       return view('indexposts', compact('posts'));
   }

       // Index method to display all posts categorized
       public function postscategorized()
       {
           // الحصول على جميع الفئات مع البوستات المرتبطة بها
           $categories = Category::with(['posts.user', 'posts.mediaFiles'])->get();
           return view('postscategories', compact('categories'));
       }

   // Create method to show form for creating a new post
   public function create()
   {
       $categories = Category::all();
       return view('createposts', compact('categories'));
   }

   // Store method to save a new post
   public function store(Request $request)
   {
       // Validate the incoming request
       $request->validate([
           'title' => 'required|string|max:255',
           'content' => 'required|string',
           'category_id' => 'required|exists:categories,id',
           'media_files.*' => 'file|mimes:jpg,jpeg,png,mp4,mp3|max:10240', // Validate media files
       ]);

       // Create a new post
       $post = Post::create([
           'title' => $request->input('title'),
           'content' => $request->input('content'),
           'category_id' => $request->input('category_id'),
           'user_id' => Auth::id(), // Set the user_id to the current logged-in user
       ]);

       // Handle media file uploads
       if ($request->hasFile('media_files')) {
           foreach ($request->file('media_files') as $file) {
               $path = $file->store('media_files', 'public'); // Store files in the public disk
               $fileExtension = strtolower($file->getClientOriginalExtension());

               $fileType = match ($fileExtension) {
                   'jpg', 'jpeg', 'png' => 'image',
                   'mp4' => 'video',
                   'mp3' => 'audio',
                   default => 'unknown', // Fallback for unexpected file types
               };

               MediaFile::create([
                   'post_id' => $post->id,
                   'file_path' => $path,
                   'file_type' => $fileType, // Use mapped file type
               ]);
           }
       }

       return redirect()->route('indexposts')->with('success', 'Post created successfully.');
   }

   // Edit method to show form for editing a post
   public function edit(Post $post)
   {
       $categories = Category::all();
       return view('editposts', compact('post', 'categories'));
   }

   // Update method to save changes to a post
   public function update(Request $request, Post $post)
   {
       $request->validate([
           'title' => 'required|string|max:255',
           'content' => 'required|string',
           'category_id' => 'required|exists:categories,id',
           'media_files.*' => 'file|mimes:jpg,jpeg,png,mp4,mp3|max:10240',
       ]);

       $post->update([
           'title' => $request->input('title'),
           'content' => $request->input('content'),
           'category_id' => $request->input('category_id'),
           'user_id' => Auth::id(),
       ]);

       if ($request->hasFile('media_files')) {
           foreach ($request->file('media_files') as $file) {
               $path = $file->store('media_files', 'public');
               $fileExtension = strtolower($file->getClientOriginalExtension());

               $fileType = match ($fileExtension) {
                   'jpg', 'jpeg', 'png' => 'image',
                   'mp4' => 'video',
                   'mp3' => 'audio',
                   default => 'unknown',
               };

               MediaFile::updateOrCreate(
                   ['post_id' => $post->id, 'file_path' => $path],
                   ['file_type' => $fileType]
               );
           }
       }

       return redirect()->route('indexposts')->with('success', 'Post updated successfully.');
   }

   // Destroy method to delete a post
   public function destroy(Post $post)
   {
       foreach ($post->mediaFiles as $mediaFile) {
           Storage::disk('public')->delete($mediaFile->file_path);
           $mediaFile->delete();
       }

       $post->delete();
       return redirect()->route('indexposts')->with('success', 'Post deleted successfully.');
   }


}
