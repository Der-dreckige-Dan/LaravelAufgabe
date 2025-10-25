<?php

use App\Models\Projekt;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('aufgaben', function (Blueprint $table) {
            $table->dateTime('deadline');
            $table->foreignIdFor(User::class)->nullable();
            $table->foreignIdFor(Projekt::class)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        //
    }
};
