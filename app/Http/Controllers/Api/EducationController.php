<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Education\CategoryResource;
use App\Http\Resources\Education\PostResource;
use App\Models\Category;
use App\Models\EducationPost;

class EducationController extends Controller
{
    public function getCategories()
    {
        $categories = Category::with(['educationPosts' => fn($q) => $q->latest()->limit(5)])->get();
        return CategoryResource::collection($categories);
    }

    public function getPostsByCategory(Category $category)
    {
        $posts = $category->educationPosts()->latest()->paginate(10);
        return PostResource::collection($posts);
    }

    public function showPost(EducationPost $educationPost)
    {
        return new PostResource($educationPost);
    }
}
