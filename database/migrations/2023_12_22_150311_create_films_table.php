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
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('nomfilm',30)->unique();
            $table->string('description');
            $table->string('imagefilm');
            $table->enum('typeven', ['film', 'stand_up', 'théatre']);
            $table->integer('prix');
            $table->integer('nbplaces');
            $table->date('datedeb');
            $table->date('datefin');
            $table->unsignedBigInteger('producerID');
            $table->foreign('producerID')
            ->references('id')
            ->on('producers')
            ->onDelete('restrict')
            ->onUpdate('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
