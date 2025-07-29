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
        Schema::table('permissions', function (Blueprint $table) {
            $table->enum('type', ['same_day', 'leave'])->default('same_day')->after('description');
            $table->time('late_arrival_time')->nullable()->after('type');
            $table->time('early_departure_time')->nullable()->after('late_arrival_time');
            $table->date('leave_start_date')->nullable()->after('early_departure_time');
            $table->date('leave_end_date')->nullable()->after('leave_start_date');
            $table->string('medical_certificate')->nullable()->after('leave_end_date');
            $table->string('proof_document')->nullable()->after('medical_certificate');
            $table->text('rejection_reason')->nullable()->after('proof_document');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn([
                'type',
                'late_arrival_time',
                'early_departure_time', 
                'leave_start_date',
                'leave_end_date',
                'medical_certificate',
                'proof_document',
                'rejection_reason'
            ]);
        });
    }
};
