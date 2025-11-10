<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_title');
            $table->text('event_description');
            $table->string('event_type');
            $table->unsignedInteger('current_participants')->default(0);
            $table->integer('expected_participants')->nullable();
            $table->string('region')->nullable();
            $table->string('location_detail')->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->json('tree_types')->nullable();
            $table->date('event_date')->nullable();
            $table->time('start_time')->nullable();
            $table->integer('duration')->nullable();
            $table->date('registration_deadline')->nullable();
            $table->string('event_image')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('pending');
            $table->timestamps();
        });        
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
