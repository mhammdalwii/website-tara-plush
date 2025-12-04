<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RecipeCategoryResource;
use App\Http\Resources\RecipeResource;
use App\Models\RecipeCategory;
use Illuminate\Http\Request;

class RecipeCategoryController extends Controller
{
    public function index()
    {
        $categories = RecipeCategory::with(['recipes' => fn($q) => $q->latest()->limit(5)])->get();
        return RecipeCategoryResource::collection($categories);
    }

    public function show(RecipeCategory $recipeCategory)
    {
        $recipes = $recipeCategory->recipes()->latest()->paginate(10);
        return RecipeResource::collection($recipes);
    }
}
