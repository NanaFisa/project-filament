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
        Schema::table('emissions', function (Blueprint $table) {
            $table->unsignedBigInteger('scope_id')->nullable()->after('id');
            
            $table->dropColumn('scope');

            $table->foreign('scope_id')->references('id')->on('scopes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emissions', function (Blueprint $table) {
            $table->dropForeign(['scope_id']);
            $table->dropColumn('scope_id');
            $table->string('scope')->nullable();
        });
    }
};
