<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\InvoiceRequest;
use App\Services\Dashboard\InvoiceService;

class InvoiceController extends Controller
{

    protected $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function index()
    {
        $lastInvoiceItemId = InvoiceItem::latest('id')->value('id');
        $clients = $this->invoiceService->getAllClients();

        return view('dashboard.invoices.index', compact('lastInvoiceItemId', 'clients'));
    }

    public function getAll()
    {
        return $this->invoiceService->getInvoicesForDatatables();
    }

    public function create()
    {
        return view('dashboard.invoices.create');
    }

    public function store(InvoiceRequest $request)
    {
        $data = $request->except(['_token']);
        $invoice = $this->invoiceService->createInvoice($data);

        if (!$invoice) {
            return response()->json([
                'status' => 'error',
                'message' => __('messages.general_error'),
            ], 500);
        }
        return response()->json([
            'status' => 'success',
            'message' => __('messages.added_successfully'),
        ], 201);
    }

    public function edit(string $id)
    {
        $invoice = $this->invoiceService->getInvoice($id);
        return view('dashboard.invoices.edit', compact('invoice'));

    }

    public function show(string $id)
    {
        $invoice = $this->invoiceService->getInvoice($id);
        $user = auth()->user();
        return view('dashboard.invoices.show', compact('invoice', 'user'));

    }

    public function update(InvoiceRequest $request, string $id)
    {
        // dd($request->all());
        $data = $request->except(['_token']);
        $invoice = $this->invoiceService->updateInvoice($id, $data);
        if (!$invoice) {
            return response()->json([
                'status' => 'error',
                'message' => __('messages.general_error'),
            ], 500);
        }
        return response()->json([
            'status' => 'success',
            'message' => __('messages.updateed_successfully')
        ], 201);

    }

    public function destroy(string $id)
    {
        if (!$this->invoiceService->deleteInvoice($id)) {
            return response()->json([
                'status' => 'error',
                'message' => __('messages.general_error'),
            ], 500);
        }
        return response()->json([
            'status' => 'success',
            'message' => __('messages.deleted_successfully')
        ], 201);

    }

    public function downloadPdf(string $id)
    {
        $invoice = $this->invoiceService->downloadPdfInvoice($id);
        if (!$invoice) {
            return response()->json([
                'status' => 'error',
                'message' => __('messages.general_error'),
            ], 500);
        }
        return $invoice;
    }

}
