<div class="form-group">
    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">

        <button class="btn btn-sm btn-outline-primary edit-invoice"
                data-id="{{ $invoice->id }}"
                data-client-id="{{ $invoice->client_id }}"
                data-invoice-date="{{ $invoice->invoice_date }}"
                data-due-date="{{ $invoice->due_date }}"
                data-total-amount="{{ $invoice->total_amount }}"
                data-items="{{ $invoice->invoiceItems->map(
                    fn($value) => [
                        'id' => $value->id,
                        'total' => $value->total,
                        'unit_price' => $value->unit_price,
                        'quantity' => $value->quantity,
                        'description' => $value->description
                    ],
                )->toJson() }}"
        >
            {{ __('dashboard.edit') }} <i class="la la-edit"></i>
        </button>

        <button
            class="btn btn-sm btn-outline-success download-invoice"
            data-url="{{ route('dashboard.invoices.show', $invoice->id) }}">
            {{ __('dashboard.show') }} <i class="la la-eye"></i>
        </button>
{{--        <button--}}
{{--            class="btn btn-sm btn-outline-success download-invoice"--}}
{{--            data-url="{{ route('dashboard.invoices.pdf', $invoice->id) }}">--}}
{{--            {{ __('dashboard.generate') }} <i class="la la-eye"></i>--}}
{{--        </button>--}}


        <button id="btnGroupDrop2" invoice-id="{{ $invoice->id }}" type="button"
                class="delete_confirm_btn btn btn-outline-danger">
            {{ __('dashboard.delete') }}<i class="la la-trash"></i>
        </button>


    </div>
</div>
