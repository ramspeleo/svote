<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('election_id')->constrained()->onDelete('cascade');
            $table->foreignId('ballot_option_id')->constrained()->onDelete('cascade');
            $table->string('voter_identifier')->unique(); // could be employee ID or email
            $table->timestamps();

            $table->unique(['election_id', 'voter_identifier']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
