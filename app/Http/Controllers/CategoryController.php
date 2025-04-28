<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $parentId = $request->input('parent_id');

        // Fetch all categories from the database
        $categories = Category::query()
            ->where(function ($query) use ($search, $parentId) {
                if ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                }
                if ($parentId) {
                    $query->where('parent_id', $parentId);
                }
            })
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

    public function store(Request $request): JsonResponse
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

    public function edit(Category $category): View
    {
        // Return the view to edit the category
        $categories = DB::table('categories')->select('id', 'name')->get();
        return view('categories.edit', [
            'category' => $category,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Category $category): JsonResponse
    {
        // Validate and update the category
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category->update($request->only('name', 'parent_id'));

        return response()->json([
            'message' => 'Category updated successfully',
        ]);
    }

    public function destroy(Category $category): JsonResponse
    {
        // Delete the category
        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully',
        ]);
    }
}
