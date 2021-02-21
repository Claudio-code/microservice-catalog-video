<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json();
    }

    public function store(Request $request): JsonResponse
    {
        return response()->json();
    }

    public function show(Category $category): JsonResponse
    {
        return response()->json();
    }

    public function update(Request $request, Category $category): JsonResponse
    {
        return response()->json();
    }

    public function destroy(Category $category): JsonResponse
    {
        return response()->json();
    }
}
