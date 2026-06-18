<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->default(0)->index();
            $table->json('title');                    // Translatable
            $table->string('url')->nullable();        // Harici / dahili URL
            $table->string('link_type', 30)->default('url'); // url, route, page, category
            $table->string('link_target', 10)->default('_self'); // _self, _blank
            $table->string('icon', 60)->nullable();   // bi bi-house vb.
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
