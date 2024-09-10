<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function receiptInvoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }
}
