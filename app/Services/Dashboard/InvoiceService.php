<?php

namespace App\Services\Dashboard;

use App\Repositories\Dashboard\InvoiceItemRepository;
use App\Utils\ImageManger;
use DB;
use Log;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Dashboard\InvoiceRepository;

class InvoiceService
{
    protected $invoiceRepository, $imageManger, $invoiceItemRepository;

    public function __construct(InvoiceRepository $invoiceRepository, ImageManger $imageManger, InvoiceItemRepository $invoiceItemRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
        $this->imageManger = $imageManger;
        $this->invoiceItemRepository = $invoiceItemRepository;
    }

    public function getInvoice($id)
    {
        $invoice = $this->invoiceRepository->getInvoice($id);

        return $invoice ?? abort(404, 'Invoice not found');
    }

    public function getAllClients()
    {
        return $this->invoiceRepository->getAllClients();
    }

    public function getInvoicesForDatatables()
    {
        $invoices = $this->getInvoices();
        return DataTables::of($invoices)
            ->addIndexColumn()
            ->addColumn('clientName', function ($invoice) {
                return $invoice->client->name ?? __('No name client');
            })
            ->addColumn('action', function ($invoice) {
                return view('dashboard.invoices.datatables.actions', compact('invoice'));
            })
//            ->addColumn('invoiceItems', function ($invoice) {
//                return view('dashboard.invoices.datatables.invoice-items', compact('invoice'));
//            })
            ->rawColumns(['action']) // for render html content
            ->make(true);
    }

    public function createInvoice($data)
    {
        try {
            DB::beginTransaction();
            $invoice = $this->invoiceRepository->createInvoice($data);
            foreach ($data['items'] as $item) {
                $this->invoiceItemRepository->createInvoiceItems($invoice, $item);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating invoice: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return false;

        }

    }


    public function updateInvoice($id, $data)
    {
        try {
            $invoice_obj = $this->getInvoice($id);

            DB::beginTransaction();
            $this->invoiceRepository->updateInvoice($invoice_obj, $data);

            $this->invoiceItemRepository->deleteInvoiceItems($invoice_obj);
            foreach ($data['items'] as $value) {
                $this->invoiceItemRepository->createInvoiceItems($invoice_obj, $value);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Updating invoice: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return false;
        }
    }

    public function deleteInvoice($id)
    {
        $invoice = $this->getInvoice($id);

        $invoice = $this->invoiceRepository->deleteInvoice($invoice);
        return $invoice;
    }

    public function downloadPdfInvoice($id)
    {
        $invoice = $this->getInvoice($id);

        $invoice = $this->invoiceRepository->downloadPdfInvoice($invoice);
        return $invoice;
    }

    public function getInvoices() // new
    {
        return $this->invoiceRepository->getInvoices();
    }

}
