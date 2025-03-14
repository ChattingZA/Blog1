<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id(); // Primary key: id
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key referencing users table
            $table->string('title'); // Post title
            $table->text('content'); // Post content
            $table->timestamps(); // created_at and updated_at timestamps
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
