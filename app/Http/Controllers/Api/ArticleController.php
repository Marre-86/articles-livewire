<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 5); // Number of items per page (default: 5)
        $page = $request->query('page', 1); // Current page (default: 1)

        // Get the last available page
        $lastPage = Article::paginate($perPage)->lastPage();

        // Validate against the last available page
        if ($page > $lastPage) {
            throw ValidationException::withMessages([
                'page' => ['The page is out of range.'],
            ]);
        }

        $articles = Article::paginate($perPage, ['*'], 'page', $page);

        return $articles;
    }

    public function getByCategory(Request $request, $category_id)
    {
        try {
            // Retrieve the category or throw an exception
            $category = Category::findOrFail($category_id);

            // Retrieve articles with the specified category_id
            $articles = Article::where('category_id', $category_id)->get();

            if ($articles->isEmpty()) {
                return response()->json(['message' => 'No articles found in this category'], 404);
            }

            return $articles;
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => 'Category not found'], 404);
        }
    }

    public function getBySlug(Request $request, $slug)
    {
        try {
            // Retrieve the article by slug or throw an exception
            $article = Article::where('slug', $slug)->firstOrFail();

            return $article;
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => 'Article not found'], 404);
        }
    }
}
