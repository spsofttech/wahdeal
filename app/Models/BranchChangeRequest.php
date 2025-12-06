<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchChangeRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'branch_id',
        'about',
        'branch',
        'menu',
        'gallery',
        'timing',
        'status'
    ];
}
