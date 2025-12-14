<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => CategoryResource::collection(Category::all()),
            'message' => null,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug',
        ]);

        $category = Category::create($validated);

        return response()->json([
            'success' => true,
            'data' => new CategoryResource($category),
            'message' => 'Category created successfully',
        ], 201);
    }

    public function newsWithCategories()
    {
        $categories = Category::with(['articles' => function ($query) {
            $query->where('status', 'published')
                ->latest('published_at')
                ->take(5);
        }])->get();

        return response()->json([
            'success' => true,
            'data' => CategoryResource::collection($categories),
            'message' => null,
        ]);
    }
}
