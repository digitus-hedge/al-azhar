<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\LogsActivity;
class Fee extends Model
{
    
   use LogsActivity;

    public const CLASSES = [
        'Pre.KG',
        'LKG',
        'UKG',
        'I',
        'II',
        'III',
        'IV',
        'V',
        'VI',
        'VII',
        'VIII',
        'IX',
        'X',
        'XI Science',
        'XI Commerce',
        'XII Science',
        'XII Commerce',
    ];

    protected $fillable = [
        'class_name',
        'fee_amount',
        'installments',
        'total_amount',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'fee_amount'   => 'decimal:2',
        'total_amount' => 'decimal:2',
        'installments' => 'integer',
        'sort_order'   => 'integer',
        'is_active'    => 'boolean',
    ];
}