<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('driver__prices', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 10, 2);

            $table->timestamps();
        });


        DB::table('driver__prices')->insert([
            'price' => '1111',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver__prices');
    }
};
