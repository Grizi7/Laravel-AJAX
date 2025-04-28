<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): View
    {
        // Fetch all categories from the database
        $categories = Category::query()
            ->with('children')
            ->paginate(5);

        $pagination = $categories->toArray()['links'];
        // Return the view with categories data
        return view('categories.index', [
            'categories' => $categories,
            'pagination' => $pagination,
            'currentPage' => $categories->currentPage(),
        ]);
    }
}
