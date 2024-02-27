<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\MediaCollections\Models\Concerns\HasUuid;

class OrderPayment extends Model
{
    use SoftDeletes, HasFactory, HasUuid;

    protected $fillable = [
        'type',
        'value',
        'credit_card_name',
        'credit_card_number',
        'credit_card_month',
        'credit_card_year',
        'credit_card_cvc',
    ];
}
