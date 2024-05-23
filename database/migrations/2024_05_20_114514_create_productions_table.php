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
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->date('datprd')->nullable(false)->default(now()); //Date du jour
            $table->foreignId('zone_id')->constrained('zones')->default(0); //Zone
            $table->foreignId('batiment_id')->constrained('batiments')->default(0); //Batiment
            $table->integer('agepou')->nullable(false)->default(0); //Age des poules
            $table->integer('nbrpou')->nullable(false)->default(0); //Nombre de poules
            $table->float('nbrcrt')->nullable(false)->default(0); //Nombre de carton
            $table->integer('prdjrn')->nullable(false)->default(0); //prduction journalière
            $table->integer('nbrcas')->nullable(false)->default(0); //Nombre d'oeufs cassés
            $table->integer('nbrdcd')->nullable(false)->default(0); //Nombre de poules dcd
            $table->integer('cnsali')->nullable(false)->default(0); // Consommation d'aliment
            $table->integer('nbrsac')->nullable(false)->default(0); // Nbre de sac
            $table->string('notes')->nullable(false)->default(0);
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productions');
    }
};
