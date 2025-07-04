<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['emission_id', 'name'];
    
    public function emission() {
        return $this->belongsTo(Emission::class);
    }

    public function activities() {
        return $this->hasMany(Activity::class);
    }
}
