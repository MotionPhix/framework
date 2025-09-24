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
        Schema::table('decisions', function (Blueprint $table) {
            $table->decimal('est_revenue', 12, 2)->nullable()->after('answers');
            $table->decimal('est_cost', 12, 2)->nullable()->after('est_revenue');
            $table->decimal('roi_percent', 6, 2)->nullable()->after('est_cost');

            $table->unsignedTinyInteger('impact')->nullable()->after('roi_percent'); // 0-10
            $table->unsignedTinyInteger('effort')->nullable()->after('impact'); // 0-10 (lower is better)
            $table->unsignedSmallInteger('time_to_value_days')->nullable()->after('effort');
            $table->unsignedTinyInteger('risk')->nullable()->after('time_to_value_days'); // 0-10 (lower is better)

            $table->text('second_order_benefits')->nullable()->after('risk');
            $table->text('second_order_risks')->nullable()->after('second_order_benefits');
            $table->string('priority')->nullable()->after('second_order_risks'); // e.g., Now, Next, Later
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('decisions', function (Blueprint $table) {
            $table->dropColumn([
                'est_revenue',
                'est_cost',
                'roi_percent',
                'impact',
                'effort',
                'time_to_value_days',
                'risk',
                'second_order_benefits',
                'second_order_risks',
                'priority',
            ]);
        });
    }
};
