<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_id')->constrained('workers')->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->timestamp('check_in')->nullable();
            $table->timestamp('check_out')->nullable();
            $table->enum('status', ['Present', 'Late', 'Absent', 'Holiday', 'HalfDay'])->default('Absent');
            $table->boolean('is_night_shift')->default(false);
            $table->decimal('regular_hours', 5, 2)->default(0);
            $table->decimal('ot_hours', 5, 2)->default(0);
            $table->integer('late_minutes')->default(0);
            $table->foreignId('scanned_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('note')->nullable();
            $table->boolean('synced_from_device')->default(false);
            $table->timestamps();

            $table->unique(['worker_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};
