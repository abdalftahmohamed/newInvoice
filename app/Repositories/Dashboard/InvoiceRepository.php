<?php

namespace App\Repositories\Dashboard;

use App\Models\Client;
use App\Models\Invoice;

class InvoiceRepository
{
    public function getInvoices()
    {
       $invoices = Invoice::with('invoiceItems')->latest()->get();
       return $invoices;
    }
    public function getAllClients()
    {
        $clients = Client::withCount(['invoices'])->when(!empty(request()->keyword), function ($query) {
            $query->where('name', 'like', '%' . request()->keyword . '%');
        })->paginate(5);

        return $clients;
    }
    public function getInvoice($id)
    {
        $invoice = Invoice::find($id);
        return $invoice;
    }
    public function createInvoice($data)
    {
        $invoiceNumber = 'INV-' . strtoupper(uniqid());
        $invoice = Invoice::create([
            'client_id' => $data['client_id'],
            'invoice_number' => $invoiceNumber,
            'invoice_date' => $data['invoice_date'],
            'due_date' => $data['due_date'],
            'total_amount' => $data['total_amount'],
            'notes' => $data['notes'] ?? null,
        ]);
        return $invoice;
    }
    public function updateInvoice($invoice, $data)
    {
        return $invoice->update([
            'client_id' => $data['client_id'],
            'invoice_date' => $data['invoice_date'],
            'due_date' => $data['due_date'],
            'total_amount' => $data['total_amount'],
            'notes' => $data['notes'],
        ]);
    }
    public function deleteInvoice($invoice)
    {
       return $invoice->delete();
    }

    public function downloadPdfInvoice($invoice)
    {
        $invoice->load('client','invoiceItems');
        $user = auth()->user();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dashboard.invoices.pdf', compact('invoice','user'));
        return $pdf->download($invoice->invoice_number . '.pdf');
    }
}
