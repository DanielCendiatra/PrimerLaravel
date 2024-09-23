<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('lastname')->nullable()->after('name');
            $table->string('address')->nullable()->after('lastname');
            $table->string('phone')->nullable()->after('address');
            $table->dateTime('date')->nullable()->after('phone');
            $table->enum('genero', ['Femenino','Masculino'])->nullable()->after('date');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('lastname');
            $table->dropColumn('address');
            $table->dropColumn('phone');
            $table->dropColumn('date');
            $table->dropColumn('genero');
        });
    }
};
