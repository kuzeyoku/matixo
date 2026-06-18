<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->json('title');                  // translatable
            $table->json('subtitle')->nullable();
            $table->json('badge_text')->nullable();
            $table->string('image')->nullable();
            $table->string('link_url')->nullable();
            $table->json('button_text')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['modal', 'section'])->default('modal');
            $table->json('title');
            $table->json('highlight_word')->nullable();
            $table->json('description')->nullable();
            $table->string('image')->nullable();
            $table->json('button_text')->nullable();
            $table->string('button_url')->nullable();
            $table->json('perks')->nullable();      // [{"text": "Ücretsiz keşif"}]
            $table->date('valid_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('show_delay_seconds')->default(2);
            $table->unsignedInteger('hide_days')->default(3);
            $table->timestamps();
        });

        Schema::create('references', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('link_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('references');
        Schema::dropIfExists('campaigns');
        Schema::dropIfExists('sliders');
    }
};
