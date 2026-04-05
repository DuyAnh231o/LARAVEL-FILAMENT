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
        Schema::create('sv23810310238_products', function (Blueprint $table) {
    $table->id();
    $table->foreignId('category_id')
          ->constrained('sv23810310238_categories')
          ->cascadeOnDelete();
    $table->string('name');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->decimal('price', 10, 2);
    $table->integer('stock_quantity');
    $table->string('image_path')->nullable();
    $table->enum('status', ['draft', 'published', 'out_of_stock'])->default('draft');

    // field sáng tạo
    $table->integer('discount_percent')->default(0);

    $table->timestamps();
});
        
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
    protected static function booted()
{
    static::saving(function ($model) {
        $model->slug = Str::slug($model->name);
    });
}

public function category()
{
    return $this->belongsTo(Category::class);
}
};
