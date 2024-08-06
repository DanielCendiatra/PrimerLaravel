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
        Schema::table('student_tasks', function (Blueprint $table) {
            $table->enum('estado', ['Vacia','Entregada','Calificada','Entrega Tardia'])->nullable()->after('note');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_tasks', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
};
