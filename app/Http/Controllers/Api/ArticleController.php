<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Http\Resources\ArticleResource;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with(['category', 'author'])
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(10);

        return ArticleResource::collection($articles)->additional([
            'success' => true,
            'message' => null,
        ]);
    }

    public function latest()
    {
        $articles = Article::with(['category', 'author'])
            ->where('status', 'published')
            ->latest('published_at')
            ->take(10)
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => ArticleResource::collection($articles),
            'message' => null,
        ]);
    }

    public function show($slug)
    {
        $article = Article::with(['category', 'author'])
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => new ArticleResource($article),
            'message' => null,
        ]);
    }

    public function byCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $articles = $category->articles()
            ->with(['category', 'author'])
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(10);

        return ArticleResource::collection($articles)->additional([
            'success' => true,
            'message' => null,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'slug' => 'required|string|unique:articles,slug',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'featured_image' => 'nullable|url',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id',
            'is_featured' => 'boolean',
            'status' => 'in:draft,published',
            'published_at' => 'nullable|date',
        ]);
        
        $article = Article::create($validated);
        
        return response()->json([
            'success' => true,
            'data' => new ArticleResource($article),
            'message' => 'Article created successfully',
        ], 201);
    }
    
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'string',
            'slug' => 'string|unique:articles,slug,' . $id,
            'content' => 'string',
            'excerpt' => 'nullable|string',
            'featured_image' => 'nullable|url',
            'category_id' => 'exists:categories,id',
            'author_id' => 'exists:authors,id',
            'is_featured' => 'boolean',
            'status' => 'in:draft,published',
            'published_at' => 'nullable|date',
        ]);
        
        $article->update($validated);
        
        return response()->json([
            'success' => true,
            'data' => new ArticleResource($article),
            'message' => 'Article updated successfully',
        ]);
    }
    
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Article deleted successfully',
        ]);
    }
}
