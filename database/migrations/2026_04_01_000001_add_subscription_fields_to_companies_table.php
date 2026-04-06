<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('phone');
            $table->string('subscription_plan')->nullable()->after('is_active');
            $table->string('subscription_status')->default('inactive')->after('subscription_plan');
            $table->string('billing_cycle')->nullable()->after('subscription_status');
            $table->timestamp('subscription_starts_at')->nullable()->after('billing_cycle');
            $table->timestamp('subscription_ends_at')->nullable()->after('subscription_starts_at');
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn([
                'is_active',
                'subscription_plan',
                'subscription_status',
                'billing_cycle',
                'subscription_starts_at',
                'subscription_ends_at',
            ]);
        });
    }
};
