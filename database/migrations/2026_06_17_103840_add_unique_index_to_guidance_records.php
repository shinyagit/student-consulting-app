<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('guidance_records', function (Blueprint $table) {
            $table->uuid('submission_token')
                ->nullable()
                ->after('user_id')
                ->unique('guidance_records_submission_token_unique');
        });
    }

    public function down(): void
    {
        Schema::table('guidance_records', function (Blueprint $table) {
            $table->dropUnique('guidance_records_submission_token_unique');
            $table->dropColumn('submission_token');
        });
    }
};