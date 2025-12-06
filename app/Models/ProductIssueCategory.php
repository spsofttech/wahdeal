<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductIssueCategory extends Model
{
    use HasFactory, SoftDeletes;

     protected $fillable = [
        'title',
        'status',
    ];

    public function reasons()
    {
        return $this->hasMany(ProductIssueReason::class, 'product_issue_category_id');
    }
}
