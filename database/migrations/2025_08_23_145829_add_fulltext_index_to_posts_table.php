<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Kolom yang ada di toSearchableArray(): title, excerpt, content_html
        DB::statement('ALTER TABLE posts ADD FULLTEXT fulltext_index(title, excerpt, content_html)');
    }

    public function down()
    {
        DB::statement('ALTER TABLE posts DROP INDEX fulltext_index');
    }
};
