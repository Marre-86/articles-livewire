<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Article extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = ['name', 'content', 'category_id', 'status', 'order', 'image'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public static function getNextOrderValue()
    {
        $maxOrder = self::max('order');
        return $maxOrder !== null ? $maxOrder + 1 : 1; // If no categories exist, start from 1
    }

    public function reorderTheRestArticles()
    {
        $orderToDelete = $this->order;
        $this->order = 999999;
        $this->save();

        // Retrieve categories to reorder
        $articlesToReorder = Article::where('order', '>', $orderToDelete)->get();

        // Decrement order values
        foreach ($articlesToReorder as $article) {
            $article->order--;
            $article->save();
        }
    }

    public function moveOrderUp()
    {
        $previousArticle = self::where('order', '<', $this->order)
                                ->orderBy('order', 'desc')
                                ->first();

        if ($previousArticle) {
            $previousArticleOrder = $previousArticle->order;
            $thisOrder = $this->order;
            $this->order = 999999;
            $this->save();
            $previousArticle->order = $thisOrder;
            $previousArticle->save();

            $this->order = $previousArticleOrder;
            $this->save();
        }
    }

    public function moveOrderDown()
    {
        $nextArticle = self::where('order', '>', $this->order)
                                ->orderBy('order', 'asc')
                                ->first();

        if ($nextArticle) {
            $nextArticleOrder = $nextArticle->order;
            $thisOrder = $this->order;
            $this->order = 999999;
            $this->save();
            $nextArticle->order = $thisOrder;
            $nextArticle->save();

            $this->order = $nextArticleOrder;
            $this->save();
        }
    }
}
