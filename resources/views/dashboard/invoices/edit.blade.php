<!-- Modal -->
<div class="modal fade" id="editInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('dashboard.edit') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                {{-- validations error --}}

                <div class="alert alert-danger" id="error_div_edit" style="display: none">
                    <ul id="error_list_edit">

                    </ul>
                </div>


                <form action="" id="" class="form updateInvoiceForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input hidden name="id" value="" id="invoiceId">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="client_id">{{ __('dashboard.client') }}</label>
                                <select class="form-control select2" name="client_id" id="invoiceClientId">
                                    <option value="">{{ __('dashboard.select_client') }}</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                                <strong class="text-danger error-message" data-error="client_id"></strong>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="invoice_date">{{ __('dashboard.invoice_date') }}</label>
                                <input type="date" value="{{ old('invoice_date') }}" class="form-control"
                                       id="invoiceInvoiceDate"
                                       placeholder="{{ __('dashboard.invoice_date') }}" name="invoice_date">
                                <strong class="text-danger error-message" data-error="invoice_date"></strong></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="due_date">{{ __('dashboard.due_date') }}</label>
                                <input type="date" value="{{ old('due_date') }}" class="form-control"
                                       id="invoiceDueDate"
                                       placeholder="{{ __('dashboard.due_date') }}" name="due_date">
                                <strong class="text-danger error-message" data-error="due_date"></strong></div>
                        </div>

                    </div>
                    <hr>
                    <div class="row invoiceItemsContainer">

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" data-values="" class="btn btn-primary add_more_edit"><i
                                    class="ft-plus"></i></button>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="total_amount">{{ __('dashboard.total_amount') }}</label>
                                <input class="form-control" name="total_amount" type="number" id="invoiceTotalAmount"
                                       value="{{old('total_amount')}}" placeholder="0">
                                <strong class="text-danger error-message" data-error="total_amount"></strong>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="notes">{{ __('dashboard.notes') }}</label>
                                <textarea class="form-control" name="notes" rows="3" id="invoiceNotes"
                                          placeholder="{{ __('dashboard.notes') }}">{{ old('notes') }}</textarea>
                                <strong class="text-danger error-message" data-error="notes"></strong>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary "
                                data-dismiss="modal"><i class="ft-x"></i>{{ __('dashboard.close') }}</button>
                        <button type="submit" class="btn btn-primary"><i
                                class="la la-check-square-o"></i> {{ __('dashboard.save') }}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
