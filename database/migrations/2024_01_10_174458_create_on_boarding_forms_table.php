<?php

use App\Models\Team;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('on_boarding_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Team::class, 'application_id')->index();

            $table->json('steps');
            $table->json('questions');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('on_boarding_forms');
    }
};
