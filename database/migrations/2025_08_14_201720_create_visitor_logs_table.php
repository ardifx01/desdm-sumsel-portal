<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('url_visited');
            $table->timestamp('visited_at');
            // Kita tidak perlu created_at/updated_at di sini
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
    }
};