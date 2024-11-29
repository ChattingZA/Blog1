<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function addCommentToPost(Request $request, $post_id)
    {
        // Validate request
        $request->validate([
            'content' => 'required|string',
        ]);

        // Create the comment
        $comment = Comment::create([
            'post_id' => $post_id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Comment added successfully!',
            'data' => $comment,
        ], 201);
    }

    /**
     * List all comments for a specific post.
     */
    public function getCommentsForPost($post_id)
    {
        // Fetch comments for the post, include the user details
        $comments = Comment::where('post_id', $post_id)->with('user')->get();

        return response()->json([
            'success' => true,
            'message' => 'Comments retrieved successfully!',
            'data' => $comments,
        ], 200);
    }
    public function updateComment(Request $request, $id)
    {
        // Find the comment
        $comment = Comment::find($id);

        // Check if comment exists
        if (!$comment) {
            return response()->json([
                'success' => false,
                'message' => 'Comment not found!',
            ], 404);
        }

        // Ensure the authenticated user owns the comment
        if ($comment->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to update this comment!',
            ], 403);
        }

        // Validate request
        $request->validate([
            'content' => 'required|string',
        ]);

        // Update the comment
        $comment->update(['content' => $request->content]);

        return response()->json([
            'success' => true,
            'message' => 'Comment updated successfully!',
            'data' => $comment,
        ], 200);
    }
    public function deleteComment($id)
    {
        // Find the comment
        $comment = Comment::find($id);

        // Check if comment exists
        if (!$comment) {
            return response()->json([
                'success' => false,
                'message' => 'Comment not found!',
            ], 404);
        }

        // Ensure the authenticated user owns the comment
        if ($comment->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to delete this comment!',
            ], 403);
        }

        // Delete the comment
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully!',
        ], 200);
    }
}
