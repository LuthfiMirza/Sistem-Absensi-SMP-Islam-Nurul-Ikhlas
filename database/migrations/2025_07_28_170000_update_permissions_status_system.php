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
            // Change is_accepted to status with enum
            $table->dropColumn('is_accepted');
            $table->enum('status', ['pending', 'review', 'accepted', 'rejected'])->default('pending')->after('permission_date');
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
            $table->dropColumn('status');
            $table->boolean('is_accepted')->nullable()->after('permission_date');
        });
    }
};