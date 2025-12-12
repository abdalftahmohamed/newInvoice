<?php

namespace App\Repositories\Dashboard;

use App\Models\InvoiceItem;

class InvoiceItemRepository
{
    public function createInvoiceItems($invoice, $value)
    {
        $invoice = $invoice->invoiceItems()->create([
            'description' => $value['description'] ?? null,
            'quantity' => $value['quantity'],
            'unit_price' => $value['unit_price'],
            'total' => $value['total'],
        ]);
        return $invoice;
    }
    public function updateInvoiceItems($invoice, $data)
    {
        return $invoice->update($data);
    }
    public function deleteInvoiceItems($invoice_obj)
    {
        return $invoice_obj->invoiceItems()->delete();
    }

}
