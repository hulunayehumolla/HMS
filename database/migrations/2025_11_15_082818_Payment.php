<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {

            // Primary Key
            $table->id();

            // Basic Info
            $table->string('invoice_number')->unique();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            //$table->foreignId('appointment_id')->nullable()->constrained()->nullOnDelete();
            //$table->foreignId('invoice_items_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('invoice_items_id')->nullable()->constrained()->nullOnDelete();
            $table->date('invoice_date');
            $table->date('due_date')->nullable();
            $table->enum('status', ['Pending','Paid','Partially Paid','Cancelled'])->default('Pending');

            // Financial Fields
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('tax_percentage', 5, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('paid_amount', 10, 2)->default(0);
            
            // Payment Information
            $table->enum('payment_method', ['Cash','bank','Insurance'])->nullable();
            $table->string('payment_for')->nullable();
            $table->enum('payment_status', ['Unpaid', 'Paid','Partial'])->default('Unpaid');
            $table->integer('quantity')->nullable();
            $table->string('transaction_reference')->nullable();
            $table->dateTime('payment_date')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};