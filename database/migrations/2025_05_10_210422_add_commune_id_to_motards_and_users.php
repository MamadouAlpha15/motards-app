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
        // Ajout à la table motards uniquement si elle n’a pas encore le champ
        Schema::table('motards', function (Blueprint $table) {
            if (!Schema::hasColumn('motards', 'commune_id')) {
                $table->foreignId('commune_id')->constrained()->onDelete('cascade');
            }
        });

        // Ajout à la table users uniquement si pas déjà là
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'commune_id')) {
                $table->foreignId('commune_id')->nullable()->constrained()->onDelete('set null');
            }
            if (!Schema::hasColumn('users', 'is_super_admin')) {
                $table->boolean('is_super_admin')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('motards', function (Blueprint $table) {
            $table->dropForeign(['commune_id']);
            $table->dropColumn('commune_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['commune_id']);
            $table->dropColumn('commune_id');
            $table->dropColumn('is_super_admin');
        });
    }
};
