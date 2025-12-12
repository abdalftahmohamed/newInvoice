<!-- Modal -->
<div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('dashboard.create') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                {{-- validations error this medola without any refresh --}}
                <div class="alert alert-danger" id="error_div" style="display: none">
                    <ul id="error_list">
                    </ul>
                </div>

                <form id="createInvoiceForm" class="form" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="client_id">{{ __('dashboard.client') }}</label>
                                <select class="form-control select2" name="client_id">
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
                                       placeholder="{{ __('dashboard.invoice_date') }}" name="invoice_date">
                                <strong class="text-danger error-message" data-error="invoice_date"></strong></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="due_date">{{ __('dashboard.due_date') }}</label>
                                <input type="date" value="{{ old('due_date') }}" class="form-control"
                                       placeholder="{{ __('dashboard.due_date') }}" name="due_date">
                                <strong class="text-danger error-message" data-error="due_date"></strong></div>
                        </div>

                    </div>
                    <hr>


                    <div class="row invoice_items_row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="unit_price">{{ __('dashboard.unit_price') }}</label>
                                <input type="number" class="form-control unit-price"
                                       placeholder="{{ __('dashboard.unit_price') }}" name="items[1][unit_price]">
                                <strong class="text-danger error-message" data-error="items[1][unit_price]"></strong>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="quantity">{{ __('dashboard.quantity') }}</label>
                                <input type="number" class="form-control quantity"
                                       placeholder="{{ __('dashboard.quantity') }}" name="items[1][quantity]">
                                <strong class="text-danger error-message" data-error="items[1][quantity]"></strong>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="total">{{ __('dashboard.total') }}</label>
                                <input type="number" class="form-control item-total"
                                       placeholder="{{ __('dashboard.total') }}" name="items[1][total]" readonly>
                                <strong class="text-danger error-message" data-error="items[1][total]"></strong>
                            </div>
                        </div>

                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="description">{{ __('dashboard.description') }}</label>
                                <textarea class="form-control"
                                          placeholder="{{ __('dashboard.description') }}"
                                          name="items[1][description]"
                                          rows="5"></textarea>
                                <strong class="text-danger error-message" data-error="items[1][description]"></strong>
                            </div>
                        </div>

                        <div class="col-md-2 mt-2">
                            <button disabled type="button" class="btn btn-danger remove">
                                <i class="ft-x"></i>
                            </button>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary" id="add_more">
                                <i class="ft-plus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="total_amount">{{ __('dashboard.total_amount') }}</label>
                                <input class="form-control" name="total_amount" type="number"
                                       value="{{old('total_amount')}}" placeholder="0" readonly>
                                <strong class="text-danger error-message" data-error="total_amount"></strong>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="notes">{{ __('dashboard.notes') }}</label>
                                <textarea class="form-control" name="notes" rows="3"
                                          placeholder="{{ __('dashboard.notes') }}">{{ old('notes') }}</textarea>
                                <strong class="text-danger error-message" data-error="notes"></strong>
                            </div>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                class="ft-x"></i>{{ __('dashboard.close') }}</button>
                        <button type="submit" class="btn btn-primary"><i class="la la-check-square-o"></i>
                            {{ __('dashboard.save') }}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
