<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductIssueReason extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_issue_category_id',
        'title',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(ProductIssueCategory::class, 'product_issue_category_id');
    }
}
