<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Constants\Status;

class CategoryController extends Controller
{
    /**
     * Get all active categories for sidebar
     */
    public function index(Request $request)
    {
        $categories = Category::active()
            ->orderBy('name', 'asc')
            ->get();

        // Transform categories for API response
        $transformedCategories = $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'icon' => $category->icon,
                'videos_count' => $category->videos()
                    ->where('status', Status::PUBLISHED)
                    ->where('visibility', Status::PUBLIC)
                    ->where('is_shorts_video', Status::NO)
                    ->count(),
            ];
        });

        return responseSuccess('categories_fetched', 'Categories fetched successfully', [
            'categories' => $transformedCategories,
            'total' => $transformedCategories->count()
        ]);
    }
}

