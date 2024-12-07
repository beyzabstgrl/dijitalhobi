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
            $table->unsignedBigInteger('community_id')->nullable();
            $table->string('title'); // Etkinlik başlığı
            $table->text('description')->nullable(); // Etkinlik açıklaması
            $table->dateTime('event_date'); // Etkinlik tarihi
            $table->string('location')->nullable(); // Etkinlik yeri
            $table->timestamps();
            $table->foreign('community_id')->references('id')->on('communities');
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
};
