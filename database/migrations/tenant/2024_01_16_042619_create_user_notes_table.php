<?php

use App\Models\Application\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_notes', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->longText('description');

            $table->timestamp('date');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on((new User())->getTable());

            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')
                ->references('id')
                ->on(
                    (new User())->getConnection()->getDatabaseName() . '.' . (new User())->getTable()
                );

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_notes');
    }
};
