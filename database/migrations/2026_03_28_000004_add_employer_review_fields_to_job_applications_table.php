<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->unsignedSmallInteger('applicant_rank')->nullable()->after('references');
            $table->text('employer_notes')->nullable()->after('applicant_rank');

            $table->index('applicant_rank');
        });
    }

    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropIndex(['applicant_rank']);
            $table->dropColumn(['applicant_rank', 'employer_notes']);
        });
    }
};
