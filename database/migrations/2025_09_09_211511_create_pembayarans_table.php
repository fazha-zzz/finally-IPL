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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');

            $table->integer('keamanan')->default(0);
            $table->integer('kebersihan')->default(0);

            $table->date('tanggal');
            $table->date('tanggal_tagih')->nullable();
            $table->date('tanggal_jatuh_tempo')->nullable();

            $table->string('status')->default('belum terbayar');

            $table->string('order_id')->nullable()->unique();
            $table->string('payment_type')->nullable();
            $table->string('transaction_status')->nullable();

            $table->string('group_order_id')->nullable()->index();

            $table->foreignId('dibayar_id')->nullable()->constrained('dibayars')->nullOnDelete();
            $table->integer('total')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
