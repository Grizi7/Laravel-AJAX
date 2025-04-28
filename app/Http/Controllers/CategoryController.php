<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
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

        $categoriesInSelect = DB::table('categories')->select('id', 'name')->get();
        // Return the view with categories data
        return view('categories.index', [
            'categories' => $categories,
            'categoriesInSelect' => $categoriesInSelect,
            'pagination' => $pagination,
            'currentPage' => $categories->currentPage(),
        ]);
    }
    public function create(): View
    {
        // Return the view to create a new category
        $categories = DB::table('categories')->select('id', 'name')->get();
        return view('categories.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        // Validate and store the new category
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        Category::create($request->only('name', 'parent_id'));

        return response()->json([
            'message' => 'Category created successfully',
        ]);
    }
}
