<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // Usando colunas personalizadas
            $table->unsignedBigInteger('users_id'); // Correto conforme o modelo
            $table->unsignedBigInteger('books_id'); // Correto conforme o modelo

            // Definindo a enum para o status da reserva
            $table->enum('situation', ['Atrasado', 'Devolvido', 'No prazo'])->default('No prazo');

            // Data de devolução
            $table->date('return_date');

            // Definindo chaves estrangeiras
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('books_id')->references('id')->on('books')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
};

