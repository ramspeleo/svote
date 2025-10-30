<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('ballot_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('election_id')->constrained()->cascadeOnDelete();
            $table->enum('label', ['YES', 'NO', 'ABSTAIN']);
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('ballot_options');
    }
};
