<?php

use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $databases = DB::select('SHOW DATABASES LIKE "agenda_ai_app_%"');

        foreach ($databases as $database) {
            $database = collect(json_decode(json_encode($database), true));

            DB::statement('DROP DATABASE ' . $database->first());
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
