<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\MediaCollections\Models\Concerns\HasUuid;

class OrderProduct extends Model
{
    use SoftDeletes, HasFactory, HasUuid;

    protected $fillable = [
        'product_id',
        'name',
        'value',
        'quantity',
    ];
}
