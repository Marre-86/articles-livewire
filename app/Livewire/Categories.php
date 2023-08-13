<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class Categories extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $id = null;
    public $name = '';
    public $status = 'Active';

    public $title = 'Add Category';
    public $sbmBtn = 'Add Category';

    public $sortField = 'order';
    public $sortDirection = 'asc';

    public $lastOrderValue;

    public function mount()
    {
        $this->lastOrderValue = Category::max('order');
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:2',
            'status' => 'required',
        ]);

        $category = Category::create([
            'name' => $this->name,
            'status' => $this->status,
            'order' => Category::getNextOrderValue(),
        ]);

        session()->flash('success', "Category {$this->name} has been added!");

        $this->name = null;
        $this->status = 'Active';
    }

    public function edit($categoryId)
    {
        $category = Category::find($categoryId);

        $this->id = $categoryId;
        $this->name = $category->name;
        $this->status = $category->status;

        $this->title = 'Edit Category';
        $this->sbmBtn = 'Update Category';
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|min:2',
            'status' => 'required',
        ]);

        $category = Category::find($this->id);

        $category->update([
            'name' => $this->name,
            'status' => $this->status,
        ]);


        session()->flash('success', "Category {$this->name} has been updated!");

        $this->id = $this->name = null;
        $this->status = 'Active';
        $this->title = 'Add Category';
    }

    public function delete($categoryId)
    {
        $categoryToDelete = Category::find($categoryId);

        $categoryToDelete->reorderTheRestCategories();

        $categoryToDelete->delete();

        session()->flash('success', "Category has been deleted!");
    }

    public function moveUp($categoryId)
    {
        $category = Category::find($categoryId);
        $category->moveOrderUp();
    }

    public function moveDown($categoryId)
    {
        $category = Category::find($categoryId);
        $category->moveOrderDown();
    }

    public function sortBy($field, $direction)
    {
        $this->sortField = $field;
        $this->sortDirection = $direction;
    }

    public function render()
    {
        $categories = Category::orderBy($this->sortField, $this->sortDirection)->paginate(10);

        return view('livewire.categories', compact('categories'));
    }
}
