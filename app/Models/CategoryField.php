<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryField extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'category_id',
        'label',
        'name',
        'type',
        'options',
        'options_selection',
        'is_required',
        'sort_order',
        'status'
    ];
}
