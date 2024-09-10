<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function invoiceCompany()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
