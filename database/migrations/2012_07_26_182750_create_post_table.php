<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('post', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title')->nullable();
            $table->string('slug')->unique();
            $table->string('post_type', 50)->index();
            $table->text('excerpt')->nullable();
            // $table->uuidMorphs('user');
            $table->json('content')->nullable();
            $table->json('meta')->nullable();
            $table->json('seo')->nullable();
            $table->unsignedBigInteger('order_column')->nullable()->index();
            $table->softDeletes();
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post');
    }
}
