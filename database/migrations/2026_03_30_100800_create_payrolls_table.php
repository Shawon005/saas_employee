<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_id')->constrained('workers')->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('month');
            $table->unsignedSmallInteger('year');
            $table->unsignedTinyInteger('total_days_present')->default(0);
            $table->unsignedTinyInteger('total_late_count')->default(0);
            $table->decimal('total_ot_hours', 6, 2)->default(0);
            $table->decimal('basic_salary', 10, 2);
            $table->decimal('house_rent', 10, 2);
            $table->decimal('medical_allowance', 10, 2);
            $table->decimal('attendance_bonus', 10, 2)->default(0);
            $table->decimal('ot_amount', 10, 2)->default(0);
            $table->decimal('friday_holiday_allowance', 10, 2)->default(0);
            $table->decimal('total_deductions', 10, 2)->default(0);
            $table->decimal('net_payable', 10, 2)->default(0);
            $table->enum('status', ['Draft', 'Finalized'])->default('Draft');
            $table->foreignId('generated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('finalized_at')->nullable();
            $table->timestamps();

            $table->unique(['worker_id', 'month', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
