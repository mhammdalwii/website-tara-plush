<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use App\Models\RecipeCategory;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * Daftar resep, bisa pakai search
     */
    public function index(Request $request)
    {
        $query = Recipe::with('recipeCategory');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $recipes = $query->latest()->paginate(10);
        return RecipeResource::collection($recipes);
    }

    /**
     * Detail satu resep berdasarkan slug
     */
    public function show($slug)
    {
        $recipe = Recipe::where('slug', $slug)->first();

        if (!$recipe) {
            return response()->json([
                'data' => null,
                'message' => 'Resep tidak ditemukan'
            ], 404);
        }

        return new RecipeResource($recipe);
    }

    /**
     * Optional: Daftar resep per kategori, bisa pakai search
     */
    public function recipesByCategory(Request $request, $slug)
    {
        $category = RecipeCategory::where('slug', $slug)->firstOrFail();
        $query = $category->recipes();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $recipes = $query->latest()->paginate(10);
        return RecipeResource::collection($recipes);
    }
}
