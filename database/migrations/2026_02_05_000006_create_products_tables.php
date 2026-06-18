<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->json('title');                          // translatable
            $table->string('slug')->unique();
            $table->string('code')->nullable()->unique();   // MTX-BSP-001
            $table->json('short_description')->nullable();  // translatable
            $table->json('description')->nullable();        // translatable (HTML - Quill)
            $table->string('material')->nullable();
            $table->string('age_range')->nullable();
            $table->string('certification')->nullable();
            $table->string('production_time')->nullable();
            $table->string('warranty')->nullable();
            $table->string('cover_image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->enum('badge', ['new', 'campaign', 'popular'])->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->unsignedBigInteger('view_count')->default(0);
            $table->json('meta_title')->nullable();
            $table->json('meta_description')->nullable();
            $table->string('og_image')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_active', 'is_featured']);
            $table->index(['category_id', 'is_active']);
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('image_path');
            $table->string('alt_text')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('product_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->json('feature_text');           // translatable
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('product_specs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->json('spec_key');               // translatable: "Boyutlar"
            $table->json('spec_value');             // translatable: "Özel ölçü"
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_specs');
        Schema::dropIfExists('product_features');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
    }
};
