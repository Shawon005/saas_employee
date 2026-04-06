<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salary_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->unique()->constrained()->cascadeOnDelete();
            $table->decimal('house_rent_percent', 5, 2)->default(50);
            $table->decimal('medical_allowance_fixed', 10, 2)->default(1500);
            $table->decimal('attendance_bonus_amount', 10, 2)->default(1000);
            $table->unsignedTinyInteger('standard_hours_per_day')->default(8);
            $table->unsignedSmallInteger('ot_divisor')->default(208);
            $table->unsignedTinyInteger('ot_multiplier')->default(2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salary_settings');
    }
};
