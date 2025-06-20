<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

class Emission extends Model
{
    protected $fillable = ['scope'];
    
    public function categories() {
        return $this->hasMany(Category::class);
    }

    public static function getEloquentQuery(): Builder {
        return parent::getEloquentQuery()->with(['categories.childCategories']);
    }
}
