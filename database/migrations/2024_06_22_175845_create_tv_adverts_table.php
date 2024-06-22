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
        Schema::create('tv_adverts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mainstream_id')->constrained('main_streams')->onDelete('cascade');
            $table->string('name_of_tv_channel');
            $table->date('date');
            $table->time('time');
            $table->time('duration_from');
            $table->time('duration_to');
            $table->boolean('repetition');
            $table->integer('repetition_count')->nullable();
            $table->decimal('cost')->nullable();
            $table->text('other_details')->nullable();
            $table->string('evidence')->nullable(); // Assuming evidence is a file path
            // Add other fields as needed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tv_adverts');
    }
};
