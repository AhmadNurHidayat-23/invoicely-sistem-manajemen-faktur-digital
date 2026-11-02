<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->string('sender_name');
            $table->text('sender_address');
            $table->string('customer_name')->index();
            $table->text('customer_address');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->unsignedInteger('tax_percentage')->default(0); // Basis poin: 1100 = 11%.
            $table->unsignedBigInteger('subtotal');
            $table->unsignedBigInteger('tax_amount');
            $table->unsignedBigInteger('total');
            $table->enum('status', ['draft', 'unpaid', 'paid'])->default('draft')->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
