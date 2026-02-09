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
        Schema::create('kritik_saran_attachment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kritik_saran_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['user', 'admin'])->default('user');
            $table->string('file_name');
            $table->string('file_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kritik_saran_attachment');
    }
};
