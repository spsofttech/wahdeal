<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferBranch extends Model
{
    protected $fillable = [
        'brand_id',
        'branch_id',
        'offer_id',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}