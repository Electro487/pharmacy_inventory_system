<?php

namespace App\Services;
use App\Models\Category;

class CategoryService {
    public function getAll()
    {
        return Category::latest()->paginate(10);
    }

    public function create(array $data): Category 
    {
        return Category::create($data);
    }

    public function update(Category $category, array $data): Category 
    {
        $category->update($data);
        return $category;
    }

    public function delete(Category $category): void
    {
        $category->delete();
    }
}
