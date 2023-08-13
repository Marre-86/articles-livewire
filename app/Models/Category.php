<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status', 'order'];

    public function articles()
    {
         return $this->hasMany('App\Models\Article', 'category_id');
    }

    public static function getNextOrderValue()
    {
        $maxOrder = self::max('order');
        return $maxOrder !== null ? $maxOrder + 1 : 1; // If no categories exist, start from 1
    }

    public function reorderTheRestCategories()
    {
        $orderToDelete = $this->order;
        $this->order = 999999;
        $this->save();

        // Retrieve categories to reorder
        $categoriesToReorder = Category::where('order', '>', $orderToDelete)->get();

        // Decrement order values
        foreach ($categoriesToReorder as $category) {
            $category->order--;
            $category->save();
        }
    }

    public function moveOrderUp()
    {
        $previousCategory = self::where('order', '<', $this->order)
                                ->orderBy('order', 'desc')
                                ->first();

        if ($previousCategory) {
            $previousCategoryOrder = $previousCategory->order;
            $thisOrder = $this->order;
            $this->order = 999999;
            $this->save();
            $previousCategory->order = $thisOrder;
            $previousCategory->save();

            $this->order = $previousCategoryOrder;
            $this->save();
        }
    }

    public function moveOrderDown()
    {
        $nextCategory = self::where('order', '>', $this->order)
                                ->orderBy('order', 'asc')
                                ->first();

        if ($nextCategory) {
            $nextCategoryOrder = $nextCategory->order;
            $thisOrder = $this->order;
            $this->order = 999999;
            $this->save();
            $nextCategory->order = $thisOrder;
            $nextCategory->save();

            $this->order = $nextCategoryOrder;
            $this->save();
        }
    }
}
