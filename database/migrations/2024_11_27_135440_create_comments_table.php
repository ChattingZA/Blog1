<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration

{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // Primary key: id
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key referencing users table
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade'); // Foreign key referencing posts table
            $table->text('content'); // Comment content
            $table->timestamps(); // created_at and updated_at timestamps
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
