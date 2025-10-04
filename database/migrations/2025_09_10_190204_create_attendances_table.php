<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->time('check_in')->nullable();
            $table->string('check_in_photo')->nullable();
            $table->time('check_out')->nullable();
            $table->string('check_out_photo')->nullable();
            $table->text('daily_report')->nullable();
            $table->timestamps();
            // Tambahkan unique index (user_id + date)
            $table->unique(['user_id', 'date']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
