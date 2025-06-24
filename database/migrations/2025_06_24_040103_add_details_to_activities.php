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
        Schema::table('activities', function (Blueprint $table) {
            if (!Schema::hasColumn('activities', 'category_id')) {
            $table->foreignId('category_id')
                ->constrained('categories') 
                ->cascadeOnDelete();
        }
            $table->string('type')->nullable();
            $table->string('unit')->nullable();
            $table->decimal('emission_factor', 8, 4)->nullable();
            $table->string('source')->nullable();
            $table->year('year')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('activities', function (Blueprint $table) {
        $table->dropForeign(['category_id']);
        $table->dropColumn([
            'category_id',
            'type',
            'unit',
            'emission_factor',
            'source',
            'year',
        ]);
    });
}
};
