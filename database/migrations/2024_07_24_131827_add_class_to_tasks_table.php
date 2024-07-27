<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('course');
            $table->foreign('course')->references('id_course')->on('courses');
            $table->unsignedBigInteger('class');
            $table->foreign('class')->references('id_class')->on('classes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['course']);
            $table->dropColumn('course');
            $table->dropForeign(['class']);
            $table->dropColumn('class');
        });
    }
};
