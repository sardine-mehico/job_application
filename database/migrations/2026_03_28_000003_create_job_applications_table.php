<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->string('job_title');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('street_address');
            $table->string('suburb')->index();
            $table->string('postcode', 4);
            $table->string('contact_number', 20);
            $table->string('email')->index();
            $table->string('work_authorization');
            $table->string('reliable_transport');
            $table->string('drivers_licence');
            $table->string('criminal_history');
            $table->string('police_clearance');
            $table->string('workers_compensation');
            $table->json('availability')->nullable();
            $table->json('education')->nullable();
            $table->json('work_history')->nullable();
            $table->json('references')->nullable();
            $table->timestamps();

            $table->index(['job_title', 'created_at']);
            $table->index(['last_name', 'first_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
