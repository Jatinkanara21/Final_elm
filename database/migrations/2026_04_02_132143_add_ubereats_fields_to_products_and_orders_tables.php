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
        Schema::table('products', function (Blueprint $table) {
            $table->string('ubereats_id')->nullable()->after('brand');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('source')->default('web')->after('user_id');
            $table->string('external_order_id')->nullable()->after('source');
            $table->string('ubereats_status')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('ubereats_id');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['source', 'external_order_id', 'ubereats_status']);
        });
    }
};
