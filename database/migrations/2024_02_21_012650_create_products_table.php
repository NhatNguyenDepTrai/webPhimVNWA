<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_category')->constrained('categories');
            $table->foreignId('id_year')->constrained('years');
            $table->foreignId('id_nation')->constrained('nations');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('highlight')->default(0);
            $table->integer('ord')->default(0);
            $table->text('url_avatar');
            $table->text('url_bg')->nullable();
            $table->string('full_name');
            $table->string('date');
            $table->string('name');
            $table->string('slug');
            $table->longText('desc')->nullable();
            $table->text('meta_image');
            $table->string('meta_title');
            $table->text('meta_desc');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
