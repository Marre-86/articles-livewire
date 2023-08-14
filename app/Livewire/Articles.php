<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Article;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Articles extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public $id = null;
    public $name = '';
    public $content = '';
    public $category = '';
    public $status = 'Active';
    public $image = null;
    public $imageName = null;

    public $title = 'Add Article';
    public $sbmBtn = 'Add Article';

    public $sortField = 'order';
    public $sortDirection = 'asc';

    public $lastOrderValue;
    public $categories;

    public function mount()
    {
        $this->lastOrderValue = Article::max('order');
        $this->categories = Category::orderBy('order', 'asc')->get();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:2',
            'category' => 'required',
            'content' => 'required',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $article = Article::create([
            'name' => $this->name,
            'content' => $this->content,
            'status' => $this->status,
            'category_id' => $this->category,
            'order' => Article::getNextOrderValue(),
        ]);

        if ($this->image) {
            $fileName = $article->slug . '.' . $this->image->extension();
            $this->image->storeAs('public/images', $fileName);
            $article->image = $fileName;
            $article->save();
        }

        session()->flash('success', "Article has been added!");

        $this->name = $this->content = $this->category = $this->image = null;

        $this->status = 'Active';
    }

    public function edit($articleId)
    {
        $article = Article::find($articleId);

        $this->id = $articleId;
        $this->name = $article->name;
        $this->content = $article->content;
        $this->category = $article->category_id;
        $this->status = $article->status;
        $this->imageName = $article->image;

        $this->title = 'Edit Article';
        $this->sbmBtn = 'Update Article';
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|min:2',
            'content' => 'required',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $article = Article::find($this->id);
        $oldName = $article->name;

        $article->update([
            'name' => $this->name,
            'content' => $this->content,
            'status' => $this->status,
            'category_id' => $this->category,
        ]);

        // renaming image in accordance with a new item name
        if ($oldName !== $this->name) {
            $oldFilePath = 'public/images/' . $article->image;
            $newFileName = $article->slug . '.' . pathinfo($article->image, PATHINFO_EXTENSION);
            $newFilePath = 'public/images/' . $newFileName;
            if (Storage::exists($oldFilePath)) {
                Storage::move($oldFilePath, $newFilePath);
            }
            $article->image = $newFileName;
            $article->save();
        }
        // overwriting image file with a new one
        if ($this->image) {
            $imageFilePath = 'public/images/' . $article->image;
            if (Storage::exists($imageFilePath)) {
                Storage::delete($imageFilePath);
            }
            $fileName = $article->slug . '.' . $this->image->extension();
            $this->image->storeAs('public/images', $fileName);
            $article->image = $fileName;
            $article->save();
        }

        session()->flash('success', "Article has been updated!");

        $this->id = $this->name = $this->content = $this->category = $this->image = null;
        $this->status = 'Active';
        $this->title = 'Add Article';
    }

    public function delete($articleId)
    {
        $articleToDelete = Article::find($articleId);

        if ($articleToDelete->image !== null) {
            $imageFilePath = 'public/images/' . $articleToDelete->image;
            if (Storage::exists($imageFilePath)) {
                Storage::delete($imageFilePath);
            }
        }

        $articleToDelete->reorderTheRestArticles();

        $articleToDelete->delete();

        session()->flash('success', "Article has been deleted!");
    }

    public function moveUp($articleId)
    {
        $article = Article::find($articleId);
        $article->moveOrderUp();
    }

    public function moveDown($articleId)
    {
        $article = Article::find($articleId);
        $article->moveOrderDown();
    }

    public function sortBy($field, $direction)
    {
        $this->sortField = $field;
        $this->sortDirection = $direction;
    }

    public function render()
    {
        if ($this->sortField === 'category') {
            $articles = Article::join('categories', 'articles.category_id', '=', 'categories.id')
                ->orderBy('categories.order', $this->sortDirection)
                ->select('articles.*')
                ->paginate(10);
        } else {
            $articles = Article::orderBy($this->sortField, $this->sortDirection)
                ->paginate(10);
        }

        return view('livewire.articles', compact('articles'));
    }
}
