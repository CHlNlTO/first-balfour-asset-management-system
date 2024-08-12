<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = ['asset_id', 'purchase_order_no', 'sales_invoice_no', 'purchase_order_date', 'purchase_cost', 'purchase_order_amount', 'vendor_id', 'requestor'];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
