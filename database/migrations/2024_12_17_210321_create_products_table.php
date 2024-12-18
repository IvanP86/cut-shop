<?php

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
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
        Schema::create('products', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('thumbnail')->nullable();
            $table->unsignedInteger('price')->default(0);
            $table->foreignId('brand_id')->index()->constrained('brands')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });

        // Schema::create('category_product', function (Blueprint $table): void {
        //     $table->id();
        //     $table->foreignId('category_id')->index()->constrained('categories')->onUpdate('cascade')->onDelete('cascade');
        //     $table->foreignId('product_id')->index()->constrained('products')->onUpdate('cascade')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (app()->isLocal()) {
            // Schema::dropIfExists('category_product');
            Schema::dropIfExists('products');
        }
    }
};
