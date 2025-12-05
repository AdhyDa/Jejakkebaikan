<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel untuk donasi dana
        Schema::create('money_donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->text('message')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->timestamps();
        });

        // Tabel untuk donasi barang
        Schema::create('goods_donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
            $table->string('item_name');
            $table->integer('quantity');
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'received'])->default('pending');
            $table->timestamps();
        });

        // Tabel untuk donasi tenaga/relawan
        Schema::create('volunteer_donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
            $table->string('position');
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });

        // Tabel untuk kebutuhan barang per campaign
        Schema::create('campaign_goods_needs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
            $table->string('item_name');
            $table->integer('quantity_needed');
            $table->integer('quantity_received')->default(0);
            $table->timestamps();
        });

        // Tabel untuk kebutuhan relawan per campaign
        Schema::create('campaign_volunteer_needs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
            $table->string('position');
            $table->integer('slots_needed');
            $table->integer('slots_filled')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Tabel untuk update/kisah berita campaign
        Schema::create('campaign_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_updates');
        Schema::dropIfExists('campaign_volunteer_needs');
        Schema::dropIfExists('campaign_goods_needs');
        Schema::dropIfExists('volunteer_donations');
        Schema::dropIfExists('goods_donations');
        Schema::dropIfExists('money_donations');
    }
};
