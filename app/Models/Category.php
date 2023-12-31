<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'description',
        'banner_url',
        'display_in_home',
    ];

    public function getAllParents(): array {
        $curParent = $this->parent;

        if (!$curParent) return [];

        $parents = [$curParent];

        while ($curParent->parent !== null) {
            $curParent = $curParent->parent;

            array_unshift($parents, $curParent);
        }

        return $parents;
    }

    /**
     * Get the products for the category.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the parent category for the category.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the child categories for the category.
     */
    public function childs(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
