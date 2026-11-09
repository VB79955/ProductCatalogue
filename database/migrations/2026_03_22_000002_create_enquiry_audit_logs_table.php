<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enquiry_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_enquiry_id')->constrained()->cascadeOnDelete();
            $table->string('action');
            $table->json('context')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enquiry_audit_logs');
    }
};
