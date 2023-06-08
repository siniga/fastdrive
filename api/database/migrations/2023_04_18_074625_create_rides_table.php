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
        Schema::create('rides', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->enum('status', ['requested', 'accepted', 'started', 'completed', 'cancelled']);
            $table->double('pickup_latitude', 10, 7);
            $table->double('pickup_longitude', 10, 7);
            $table->double('dropoff_latitude', 10, 7);
            $table->double('dropoff_longitude', 10, 7);
            $table->string('pickup_address');
            $table->string('price');
            $table->string('dropoff_address');
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('set null');
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};
