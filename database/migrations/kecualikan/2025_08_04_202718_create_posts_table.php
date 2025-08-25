<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('posts', function (Blueprint $table) {
            $table->id(); // Menggunakan bigIncrements (id) untuk konsistensi
            $table->string('title');
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content_html')->nullable();
            $table->string('featured_image_url')->nullable();
            
            // Foreign key untuk kategori
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            
            // Foreign key untuk author
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            
            $table->enum('status', ['published', 'draft'])->default('draft');
            $table->unsignedBigInteger('hits')->default(0);
            $table->unsignedBigInteger('share_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};