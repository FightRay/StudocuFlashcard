<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('action');
            $table->timestamps();
        });

        $records = [
            [ 'name' => 'Create a flashcard', 'action' => 'create' ],
            [ 'name' => 'List all flashcards', 'action' => 'list' ],
            [ 'name' => 'Practice', 'action' => 'practice' ],
            [ 'name' => 'Statistics', 'action' => 'stats' ],
            [ 'name' => 'Reset', 'action' => 'reset' ]
        ];

        DB::table('menu_items')->insert($records);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_items');
    }
};
