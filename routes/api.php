<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

// Register route
Route::post('/register', [AuthController::class, 'register']);
// Login route
Route::post('/login', [AuthController::class, 'login']);
// Logout route
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Create Post Route
Route::middleware('auth:sanctum')->post('/posts', [PostController::class, 'createPost']);
// List all posts route
Route::get('/posts', [PostController::class, 'getAllPosts']);
// View a single post route
Route::get('/posts/{id}', [PostController::class, 'getSinglePost']);
// update own post
Route::middleware('auth:sanctum')->put('/posts/{id}', [PostController::class, 'updatePost']);
// delete own post
Route::middleware('auth:sanctum')->delete('/posts/{id}', [PostController::class, 'deletePost']);

// List all comments for a specific post
Route::get('/posts/{post_id}/comments', [CommentController::class, 'getCommentsForPost']);
// Add a comment to a specific post
Route::middleware('auth:sanctum')->post('/posts/{post_id}/comments', [CommentController::class, 'addCommentToPost']);
// Update a comment
Route::middleware('auth:sanctum')->put('/comments/{id}', [CommentController::class, 'updateComment']);
// Delete a comment
Route::middleware('auth:sanctum')->delete('/comments/{id}', [CommentController::class, 'deleteComment']);


// protected route
Route::middleware('auth:sanctum')->get('/profile', function (Request $request) {
  return response()->json($request->user());
});
