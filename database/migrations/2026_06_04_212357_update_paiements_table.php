<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('paiements', function (Blueprint $table) {
            // Ajouter les colonnes manquantes
            $table->decimal('montant', 10, 0)->after('reservation_id');
            $table->timestamp('date_paiement')->nullable()->after('statut');
            
            // Modifier transaction_id pour accepter null
            $table->string('transaction_id')->nullable()->unique()->change();
        });
    }

    public function down(): void
    {
        Schema::table('paiements', function (Blueprint $table) {
            $table->dropColumn(['montant', 'date_paiement']);
            $table->string('transaction_id')->nullable(false)->unique()->change();
        });
    }
};