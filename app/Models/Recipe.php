<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipe_category_id',
        'title',
        'slug',
        'image',
        'description',
        'ingredients',
        'instructions',
        'prep_time',
        'cook_time',
        'servings',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($recipe) {
            if (empty($recipe->slug)) {
                $recipe->slug = Str::slug($recipe->title);
            }
        });

        static::updating(function ($recipe) {
            if (empty($recipe->slug)) {
                $recipe->slug = Str::slug($recipe->title);
            }
        });
    }
    public function recipeCategory(): BelongsTo
    {
        return $this->belongsTo(RecipeCategory::class);
    }
}
