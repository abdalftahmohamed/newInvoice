@extends('layouts.dashboard.app')
@section('title')
    @lang('dashboard.invoices')
@endsection
@push('style')
@endpush
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">{{ __('dashboard.invoices') }}</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('dashboard.home') }}">{{ __('dashboard.dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.invoices.index') }}">
                                        {{ __('dashboard.invoices') }}</a>
                                </li>


                            </ol>
                        </div>
                    </div>
                </div>
                {{-- @include('dashboard.includes.button-header') --}}
            </div>
            <div class="row" style="display: flex; justify-content: center;">
                <div class="col-md-11">
                    <div class="content-body">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" id="basic-layout-colored-form-control">
                                    {{ __('dashboard.invoices') }}
                                </h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-content">
                                <div class="card-body">

                                    {{-- create invoice modal --}}
                                    <button type="button" id="invoiceModalButton" class="btn btn-outline-success "
                                            data-toggle="modal" data-target="#invoiceModal">
                                        {{ __('dashboard.create') }}
                                    </button>

                                    {{-- modal --}}
                                    @include('dashboard.invoices.create')
                                    @include('dashboard.invoices.edit')
                                    {{-- end create invoice modal --}}

                                    {{-- <p class="card-text">{{ __('dashboard.table_yajra_paragraph') }}.</p> --}}
                                    <table id="yajra_table" class="table table-striped table-bordered language-file">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('dashboard.client') }}</th>
                                            <th>{{ __('dashboard.invoice_number') }}</th>
                                            {{--                                            <th>{{ __('dashboard.invoiceItems') }}</th>--}}
                                            <th>{{ __('dashboard.invoice_date') }}</th>
                                            <th>{{ __('dashboard.due_date') }}</th>
                                            <th>{{ __('dashboard.total_amount') }}</th>
                                            <th>{{ __('dashboard.actions') }}</th>
                                        </tr>
                                        </thead>

                                        <body>
                                        {{-- empty --}}
                                        </body>
                                        <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('dashboard.client') }}</th>
                                            <th>{{ __('dashboard.invoice_number') }}</th>
                                            {{--                                            <th>{{ __('dashboard.invoiceItems') }}</th>--}}
                                            <th>{{ __('dashboard.invoice_date') }}</th>
                                            <th>{{ __('dashboard.due_date') }}</th>
                                            <th>{{ __('dashboard.total_amount') }}</th>
                                            <th>{{ __('dashboard.actions') }}</th>
                                        </tr>
                                        </tfoot>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')

    {{--  Data tables  --}}
    <script>
        var lang = "{{ app()->getLocale() }}";

        var table = $('#yajra_table').DataTable({
            processing: true,
            serverSide: true,
            fixedHeader: true,

            colReorder: true,
            rowReorder: {
                update: false,
                selector: "td:not(:first-child)",
            },
            // scroller: true,
            // scrollY: 900,
            select: true,
            responsive: {
                details: {
                    display: DataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return '@lang('dashboard.Details for') ' + data['name'];
                        }
                    }),
                    renderer: DataTable.Responsive.renderer.tableAll({
                        tableClass: 'table'
                    })
                }
            },
            ajax: "{{ route('dashboard.invoices.all') }}",
            columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false,
            },
                {
                    data: 'clientName',
                    name: 'clientName',
                },
                {
                    data: 'invoice_number',
                    name: 'invoice_number',
                },
                // {
                //     data: 'invoiceItems',
                //     name: 'invoiceItems',
                // },
                {
                    data: 'invoice_date',
                    name: 'invoice_date',
                },
                {
                    data: 'due_date',
                    name: 'due_date',
                },
                {
                    data: 'total_amount',
                    name: 'total_amount',
                },
                {
                    data: 'action',
                    searchable: false,
                    orderable: false,
                },

            ],
            layout: {
                topStart: {
                    buttons: ['colvis', 'copy', 'print', 'excel', 'pdf']
                }
            },
            language: lang === 'ar' ? {
                url: "{{ asset('vendor/dataTables/languages/ar.json') }}",
            } : {},
        });
        // disable the row order when cliking
        $('table').on('mousedown', 'button', function (e) {
            table.rowReorder.disable();
        });
        $('table').on('mouseup', 'button', function (e) {
            table.rowReorder.enable();
        });

        // Create Invoice Usin ajax Request
        $('#invoiceModalButton').on('click', function () {
            $('#error_list').empty();
            $('#error_div').hide();
        })


    </script>










    {{-- // add new items to invoice in case create  and edit--}}
    <script>

        // Utility: recalc grand total
        function recalcGrandTotal() {
            let sum = 0;
            $('input.item-total').each(function () {
                let val = parseFloat($(this).val());
                if (!isNaN(val)) sum += val;
            });
            // Update total_amount input(s) - adjust selector if you have multiple instances
            $('input[name="total_amount"]').val(sum.toFixed(2));
        }

        // Calculate single row total given row element
        function calculateRowTotal($row) {
            let unit = parseFloat($row.find('input.unit-price').val());
            let qty = parseFloat($row.find('input.quantity').val());
            unit = isNaN(unit) ? 0 : unit;
            qty = isNaN(qty) ? 0 : qty;
            let total = unit * qty;
            $row.find('input.item-total').val(total.toFixed(2));
            return total;
        }

        // When DOM ready - wire events (works for existing and dynamic rows)
        $(document).ready(function () {
            // Delegate input event for unit price and quantity (works for dynamic rows too)
            $(document).on('input', 'input.unit-price, input.quantity', function () {
                let $row = $(this).closest('.invoice_items_row, .invoiceItemsContainer, .row.invoice_items_row, .row.invoiceItemsContainer');
                calculateRowTotal($row);
                recalcGrandTotal();
            });

            // Recalculate totals when page loads for existing values (edit modal)
            // If edit modal populates rows dynamically, call this after populating items.
            $(document).on('shown.bs.modal', '#invoiceModal, #editInvoiceModal', function () {
                // For each invoice item row, ensure it has the classes and calculate its total
                $(this).find('.invoice_items_row, .invoiceItemsContainer').each(function () {
                    let $r = $(this);
                    // Add classes to matching inputs if not present (useful when using server-rendered markup)
                    if ($r.find('input[name*="[unit_price]"]').length && $r.find('input.unit-price').length === 0) {
                        $r.find('input[name*="[unit_price]"]').addClass('unit-price');
                    }
                    if ($r.find('input[name*="[quantity]"]').length && $r.find('input.quantity').length === 0) {
                        $r.find('input[name*="[quantity]"]').addClass('quantity');
                    }
                    if ($r.find('input[name*="[total]"]').length && $r.find('input.item-total').length === 0) {
                        $r.find('input[name*="[total]"]').addClass('item-total').prop('readonly', true);
                    }

                    calculateRowTotal($r);
                });

                recalcGrandTotal();
            });
        });


        function getLastIndex() {
            let lastIndex = 0;
            $('input[name^="items["][name$="[unit_price]"]').each(function () {
                let name = $(this).attr('name'); // <-- FIXED
                let match = name.match(/items\[(\d+)\]\[unit_price\]/);

                if (match) {
                    let index = parseInt(match[1]);
                    if (index > lastIndex) lastIndex = index;
                }
            });

            return lastIndex;
        }

        $(document).ready(function () {
            // let itemIndex = 2
            $('#add_more').on('click', function (e) {
                e.preventDefault();
                let itemIndex = getLastIndex() + 1;
                let newRow = `
<div class="row invoice_items_row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="unit_price">{{ __('dashboard.unit_price') }}</label>
            <input type="number" class="form-control unit-price"
                name="items[${itemIndex}][unit_price]"
                placeholder="{{ __('dashboard.unit_price') }}">
            <strong class="text-danger error-message" data-error="items[${itemIndex}][unit_price]"></strong>
        </div>
    </div>

        <div class="col-md-4">
        <div class="form-group">
            <label for="quantity">{{ __('dashboard.quantity') }}</label>
            <input type="number" class="form-control quantity"
                name="items[${itemIndex}][quantity]"
                placeholder="{{ __('dashboard.quantity') }}">
            <strong class="text-danger error-message" data-error="items[${itemIndex}][quantity]"></strong>
        </div>
    </div>

        <div class="col-md-4">
        <div class="form-group">
            <label for="total">{{ __('dashboard.total') }}</label>
            <input type="number" class="form-control item-total"
                name="items[${itemIndex}][total]"
                placeholder="{{ __('dashboard.total') }}" >
            <strong class="text-danger error-message" data-error="items[${itemIndex}][total]"></strong>
        </div>
    </div>

    <div class="col-md-10">
                            <div class="form-group">
                                <label for="description">{{ __('dashboard.description') }}</label>
                                <textarea class="form-control"
                                          placeholder="{{ __('dashboard.description') }}"
                                          name="items[${itemIndex}][description]"
                                          rows="5"></textarea>
                                <strong class="text-danger error-message" data-error="items[${itemIndex}][description]"></strong>
                            </div>
                        </div>


    <div class="col-md-2 mt-2">
        <button type="button" class="btn btn-danger remove"><i class="ft-x"></i></button>
    </div>
</div>
`;

                $('.invoice_items_row:last').after(newRow);
            });
        })

        // ########### Delete Invoice Item Input Field ###########
        $(document).on('click', '.remove', function () {
            $(this).closest('.invoice_items_row').remove();
            $(this).closest('.invoiceItemsContainer').remove();
        });


        // #################### Edit Invoice #################
        $(document).on('click', '.edit-invoice', function () {
            let id = $(this).data('id');
            let invoiceDate = $(this).data('invoiceDate');
            let dueDate = $(this).data('dueDate');
            let totalAmount = $(this).data('totalAmount');
            let items = $(this).data('items');
            let clientId = $(this).data('clientId');

            $('.invoiceItemsContainer').empty(); // Remove old rows

            $('#invoiceClientId').val(clientId).trigger('change');
            // Populate name fields
            $('#invoiceId').val(id);
            $('#invoiceInvoiceDate').val(invoiceDate);
            $('#invoiceDueDate').val(dueDate);
            $('#invoiceTotalAmount').val(totalAmount);
            // Clear and populate items container
            let itemsContainer = $('.invoiceItemsContainer:last');
            itemsContainer.empty();

            items.forEach((item, index) => {
                itemsContainer.after(`
                    <div class="row invoiceItemsContainer">
                    <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="unit_price">{{ __('dashboard.unit_price') }}</label>
                                        <input type="number" name="items[${item.id}][unit_price]" class="form-control unit-price"
                                            value="${item.unit_price}"
                                            placeholder="{{ __('dashboard.unit_price') }}">
                                    </div>
                                </div>

                                   <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="quantity">{{ __('dashboard.quantity') }}</label>
                                        <input type="number" name="items[${item.id}][quantity]" class="form-control quantity"
                                            value="${item.quantity}"
                                            placeholder="{{ __('dashboard.quantity') }}">
                                    </div>
                                </div>


                                     <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="total">{{ __('dashboard.total') }}</label>
                                        <input type="number" name="items[${item.id}][total]" class="form-control item-total"
                                            value="${item.total}"
                                            placeholder="{{ __('dashboard.total') }}"  readonly>
                                    </div>
                                </div>


                                    <div class="col-md-10">
                            <div class="form-group">
                                <label for="description">{{ __('dashboard.description') }}</label>
                                <textarea class="form-control"
                                          placeholder="{{ __('dashboard.description') }}"
                                          name="items[${item.id}][description]"
                                          rows="5">${item.description}</textarea>
                                <strong class="text-danger error-message" data-error="${item.description}"></strong>
                            </div>
                        </div>
                                <div class="col-md-2 mt-2">
                                    <button type="button" class="btn btn-danger remove "><i class="ft-x"></i></button>
                    </div>
                    </div>

                `);
            });


            // // delete validation error on click
            $('#error_list_edit').empty();
            $('#error_div_edit').hide();
            // Show the modal
            $('#editInvoiceModal').modal('show');
        });

        function getLastIndexEdit() {
            let lastIndex = {{ ($lastInvoiceItemId ?? 0) + 1 }};

            $('input[name^="items["][name$="[unit_price]"]').each(function () {
                let name = $(this).attr('name'); // <-- FIXED
                let match = name.match(/items\[(\d+)\]\[unit_price\]/);

                if (match) {
                    let index = parseInt(match[1]);
                    if (index > lastIndex) lastIndex = index;
                }
            });


            return lastIndex;
        }

        // add new items to invoice in case edit
        $(document).ready(function () {
            let itemIndex = getLastIndexEdit() + 1;
            {{--            let itemIndex = "{{$lastInvoiceItemId+1}}";--}}
            $('.add_more_edit').on('click', function (e) {
                e.preventDefault();
                let newRow = `
                            <div class="row invoiceItemsContainer">
                             <div class="col-md-4">
        <div class="form-group">
            <label for="unit_price">{{ __('dashboard.unit_price') }}</label>
            <input type="number" class="form-control unit-price"
                name="items[${itemIndex}][unit_price]"
                placeholder="{{ __('dashboard.unit_price') }}">
            <strong class="text-danger error-message" data-error="items[${itemIndex}][unit_price]"></strong>
        </div>
    </div>

        <div class="col-md-4">
        <div class="form-group">
            <label for="quantity">{{ __('dashboard.quantity') }}</label>
            <input type="number" class="form-control quantity"
                name="items[${itemIndex}][quantity]"
                placeholder="{{ __('dashboard.quantity') }}">
            <strong class="text-danger error-message" data-error="items[${itemIndex}][quantity]"></strong>
        </div>
    </div>

        <div class="col-md-4">
        <div class="form-group">
            <label for="total">{{ __('dashboard.total') }}</label>
            <input type="number" class="form-control item-total"
                name="items[${itemIndex}][total]"
                placeholder="{{ __('dashboard.total') }}" readonly>
            <strong class="text-danger error-message" data-error="items[${itemIndex}][total]"></strong>
        </div>
    </div>

    <div class="col-md-10">
                            <div class="form-group">
                                <label for="description">{{ __('dashboard.description') }}</label>
                                <textarea class="form-control"
                                          placeholder="{{ __('dashboard.description') }}"
                                          name="items[${itemIndex}][description]"
                                          rows="5"></textarea>
                                <strong class="text-danger error-message" data-error="items[${itemIndex}][description]"></strong>
                            </div>
                        </div>


                                <div class="col-md-2 mt-2">
                                        <button type="button" class="btn btn-danger remove" ><i class="ft-x"></i></button>
                                </div>
                            </div>`;

                // Append the new row to the form
                $('.invoiceItemsContainer:last').after(newRow);

                itemIndex++; // Increment the counter for the next row
            });
        });


        // delete invoice using ajax & Jquery
        $(document).on('click', '.delete_confirm_btn', function (e) {
            e.preventDefault();
            var invoice_id = $(this).attr('invoice-id');

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('dashboard.invoices.destroy', 'id') }}".replace('id',
                            invoice_id),
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            if (response.status == 'success') {
                                Swal.fire({
                                    title: response.status,
                                    text: response.message,
                                    icon: "success"
                                });
                                $('#yajra_table').DataTable().ajax.reload();
                            } else {
                                Swal.fire({
                                    title: response.status,
                                    text: response.message,
                                    icon: "error"
                                });
                            }
                        }
                    });

                }
            });

        });

        // create invoice Using Ajax
        $('#createInvoiceForm').on('submit', function (e) {
            e.preventDefault();
            var currentPage = $('#yajra_table').DataTable().page(); // get the current page number
            $.ajax({
                url: "{{ route('dashboard.invoices.store') }}",
                method: 'post',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {
                    console.log(data);
                    if (data.status == 'success') {
                        // console.log(data);
                        $('#createInvoiceForm')[0].reset();
                        $('#yajra_table').DataTable().page(currentPage).draw(false);
                        $('#invoiceModal').modal('hide');
                        Swal.fire({
                            position: "top-center",
                            icon: "success",
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            position: "top-center",
                            icon: "error",
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }

                },

                // show error uder each input field
                error: function (data) {
                    // Clear previous errors
                    $('.error-message').text('');

                    if (data.responseJSON.errors) {
                        // console.log(data.responseJSON.errors);
                        $.each(data.responseJSON.errors, function (key, value) {

                            // Convert dot notation to bracket notation
                            // name.en -> name[en]
                            // items.1.ar -> items[1][ar]
                            let bracketKey = key.replace(/\.(\w+)/g, '[$1]');

                            // Escape for jQuery
                            let safeKey = bracketKey.replace(/\[/g, "\\[").replace(/\]/g, "\\]");

                            // Select the matching error message element
                            let errorElement = $(`strong[data-error="${safeKey}"]`);

                            if (errorElement.length) {
                                errorElement.text(value[0]);
                            }
                        });
                    }
                }
                //end error


            });
        })

        // Update invoice Using Ajax
        $('.updateInvoiceForm').on('submit', function (e) {
            e.preventDefault();
            var currentPage = $('#yajra_table').DataTable().page(); // get the current page number
            var invoice_id = $('#invoiceId').val();
            $.ajax({
                url: "{{ route('dashboard.invoices.update', 'id') }}".replace('id', invoice_id),
                method: 'post',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {
                    // console.log(data);
                    if (data.status == 'success') {
                        $('#yajra_table').DataTable().page(currentPage).draw(false);
                        $('#editInvoiceModal').modal('hide');
                        Swal.fire({
                            position: "top-center",
                            icon: "success",
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                    if (data.status == 'error') {
                        Swal.fire({
                            position: "top-center",
                            icon: "error",
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }

                },
                // show error uder each input field
                error: function (data) {
                    // Clear previous errors
                    $('.error-message-edit').text('');

                    if (data.responseJSON.errors) {
                        $('#error_list_edit').empty();

                        $.each(data.responseJSON.errors, function (key, value) {

                            $('#error_list_edit').append('<li>' + value[0] + '</li>');
                            $('#error_div_edit').show();
                            // Convert dot notation to bracket notation
                            // name.en -> name[en]
                            // items.1.ar -> items[1][ar]
                            let bracketKey = key.replace(/\.(\w+)/g, '[$1]');

                            // Escape for jQuery
                            let safeKey = bracketKey.replace(/\[/g, "\\[").replace(/\]/g, "\\]");

                            // Select the matching error message element
                            let errorElement = $(`strong[data-error="${safeKey}"]`);

                            if (errorElement.length) {
                                errorElement.text(value[0]);
                            }

                        });
                    }
                }
                //end error


            });
        })


        // download invoice Using Ajax
        $(document).on('click', '.download-invoice', function () {
            window.open($(this).data('url'), '_blank');
        });
    </script>

@endpush
