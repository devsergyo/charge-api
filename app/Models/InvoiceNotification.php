<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceNotification extends Model
{
    
    protected $fillable = [
        'invoice_id',
        'type',
        'status',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
    ];


    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
