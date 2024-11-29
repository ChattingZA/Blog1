<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Create a new post.
     */
    public function createPost(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Create a new post
        $post = Post::create([
            'user_id' => $request->user()->id, // Get authenticated user's ID
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Post created successfully!',
            'data' => $post,
        ], 201);
    }

    /**
     * List all posts with optional search and filter options.
     */
    public function getAllPosts(Request $request)
    {
        // Optional filters: search by title or content
        $search = $request->input('search'); // For search query
        $userId = $request->input('user_id'); // Filter by user ID

        // Query the posts
        $query = Post::query();

        // Add search condition if provided
        if ($search) {
            $query->where('title', 'LIKE', "%$search%")
                ->orWhere('content', 'LIKE', "%$search%");
        }

        // Add user ID filter if provided
        if ($userId) {
            $query->where('user_id', $userId);
        }

        // Get the posts, paginated (10 posts per page)
        $posts = $query->with('user')->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Posts retrieved successfully!',
            'data' => $posts,
        ], 200);
    }

    public function getSinglePost($id)
    {
        // Find the post by ID and include related user and comments
        $post = Post::with(['user', 'comments.user'])->find($id);

        // Check if the post exists
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found!',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Post retrieved successfully!',
            'data' => $post,
        ], 200);
    }

    public function updatePost(Request $request, $id)
    {
        // Find the post
        $post = Post::find($id);

        // Check if post exists
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found!',
            ], 404);
        }

        // Ensure the authenticated user owns the post
        if ($post->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to update this post!',
            ], 403);
        }

        // Validate the request
        $request->validate([
            'title' => 'string|max:255',
            'content' => 'string',
        ]);

        // Update the post
        $post->update($request->only(['title', 'content']));

        return response()->json([
            'success' => true,
            'message' => 'Post updated successfully!',
            'data' => $post,
        ], 200);
    }
    public function deletePost($id)
    {
        // Find the post
        $post = Post::find($id);

        // Check if post exists
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found!',
            ], 404);
        }

        // Ensure the authenticated user owns the post
        if ($post->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to delete this post!',
            ], 403);
        }

        // Delete the post
        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully!',
        ], 200);
    }
}
