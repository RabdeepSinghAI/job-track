<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('contact_name')->nullable()->after('url');
            $table->date('interview_date')->nullable()->after('applied_at');
            $table->boolean('needs_followup')->default(false)->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['contact_name', 'interview_date', 'needs_followup']);
        });
    }
};