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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('image');
            $table->string('category');
            $table->string('organization_name');
            $table->decimal('target_amount', 15, 2)->nullable();
            $table->decimal('collected_amount', 15, 2)->default(0);
            $table->date('end_date');
            $table->boolean('need_money')->default(false);
            $table->boolean('need_goods')->default(false);
            $table->boolean('need_volunteer')->default(false);
            $table->enum('status', ['draft', 'active', 'finished'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
