<?php

namespace App\Models;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Audits extends Model
{
    use HasFactory;

    protected $table = 'audits';
    
    protected $fillable = [
        'audit_date',
        'picture',
        'description',
        'rating',
        'sub_category_id',
    ];

    public function category()
    {
        return $this->hasOneThrough(
            Category::class,
            SubCategory::class,
            'id',
            'id',
            'sub_category_id',
            'category_id',
        );
    }

    public function sub_category() {
        return $this->hasOne(SubCategory::class, 'id', 'sub_category_id');
    }

}
