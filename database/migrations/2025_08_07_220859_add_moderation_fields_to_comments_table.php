<?php

// database/migrations/xxxx_xx_xx_add_moderation_fields_to_comments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->string('name')->nullable()->after('user_id');
            $table->string('email')->nullable()->after('name');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn(['name', 'email', 'status']);
        });
    }
};