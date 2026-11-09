<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_enquiries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->uuid('reference')->unique();
            $table->string('name', 120);
            $table->string('email');
            $table->string('phone', 30);
            $table->text('message');
            $table->string('status', 32)->default('submitted');
            $table->timestamps();

            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_enquiries');
    }
};
