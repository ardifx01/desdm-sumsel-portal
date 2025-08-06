<?php

// database/migrations/xxxx_xx_xx_create_comments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            // post_id harus unsignedInteger karena posts.id adalah int
            $table->unsignedInteger('post_id');
            // user_id harus unsignedBigInteger karena users.id adalah bigint
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};