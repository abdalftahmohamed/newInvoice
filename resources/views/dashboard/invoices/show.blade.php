@extends('layouts.dashboard.app')
@section('title')
    @lang('dashboard.invoices')
@endsection
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/dashboard') }}/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/dashboard') }}/css/pages/invoice.css">
@endpush
@section('content')
    @php
        use Carbon\Carbon;

        // safe helpers
        $companyName = $user->name ?? config('app.name', 'Your Company');
        $companyEmail = $user->email ?? null;
        $companyPhone = $user->phone ?? null;
        $companyAddress = $user->address ?? null;

        // detect if rendering for PDF (you may pass compact('invoice','pdf') from controller)
        $isPdf = $isPdf ?? false;
    @endphp
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
            </div>

            <div class="content-body">
                <section class="card">
                    <div id="invoice-template" class="card-body">

                        <!-- Invoice Company Details -->
                        <div id="invoice-company-details" class="row">
                            <div class="col-md-6 col-sm-12 text-center text-md-left">
                                <div class="media">
{{--                                    <img src="{{ $logo }}" alt="company logo"--}}
{{--                                         style="width:80px;height:80px;object-fit:contain;"/>--}}
                                    <div class="media-body ml-2">
                                        <ul class="ml-2 px-0 list-unstyled">
                                            <li class="text-bold-800">{{ $companyName }}</li>
                                            @if($companyAddress)
                                                @foreach(explode("\n", $companyAddress) as $line)
                                                    <li>{{ trim($line) }}</li>
                                                @endforeach
                                            @else
                                                <li>4025 Oak Avenue,</li>
                                                <li>Melbourne,</li>
                                                <li>Florida 32940,</li>
                                                <li>USA</li>
                                            @endif
                                            @if($companyEmail)
                                                <li>{{ $companyEmail }}</li>
                                            @endif
                                            @if($companyPhone)
                                                <li>{{ $companyPhone }}</li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12 text-center text-md-right">
                                <h2>INVOICE</h2>
                                <p class="pb-3"># {{ $invoice->invoice_number }} <span
                                        class="badge badge-success">{{ $invoice->status }}</span></p>


                                <ul class="px-0 list-unstyled">
                                    <li>Balance Due</li>
                                    <li class="lead text-bold-800">${{ number_format($invoice->total_amount, 2) }}</li>
                                </ul>
                            </div>
                        </div>
                        <!--/ Invoice Company Details -->

                        <!-- Invoice Customer Details -->
                        <div id="invoice-customer-details" class="row pt-2">
                            <div class="col-sm-12 text-center text-md-left">
                                <p class="text-muted">Bill To</p>
                            </div>

                            <div class="col-md-6 col-sm-12 text-center text-md-left">
                                <ul class="px-0 list-unstyled">
                                    <li class="text-bold-800">{{ optional($invoice->client)->name ?? '—' }}</li>
                                    @if(optional($invoice->client)->address)
                                        @foreach(explode("\n", optional($invoice->client)->address) as $line)
                                            <li>{{ trim($line) }}</li>
                                        @endforeach
                                    @elseif(optional($invoice->client)->street || optional($invoice->client)->city)
                                        <li>{{ optional($invoice->client)->street }}</li>
                                        <li>{{ optional($invoice->client)->city }}
                                            , {{ optional($invoice->client)->state }}</li>
                                        <li>{{ optional($invoice->client)->country }}</li>
                                    @else
                                        <li>4879 Westfall Avenue,</li>
                                        <li>Albuquerque,</li>
                                        <li>New Mexico-87102.</li>
                                    @endif

                                    @if(optional($invoice->client)->email)
                                        <li>{{ optional($invoice->client)->email }}</li>
                                    @endif
                                    @if(optional($invoice->client)->phone)
                                        <li>{{ optional($invoice->client)->phone }}</li>
                                    @endif
                                </ul>
                            </div>

                            <div class="col-md-6 col-sm-12 text-center text-md-right">
                                <p><span class="text-muted">Invoice Date :</span> {{ $invoice->invoice_date }}</p>
                                <p><span class="text-muted">Terms :</span> Due on Receipt</p>
                                <p><span class="text-muted">Due Date :</span> {{ $invoice->due_date ?? '—' }}</p>
                            </div>
                        </div>
                        <!--/ Invoice Customer Details -->

                        <!-- Invoice Items Details -->
                        <div id="invoice-items-details" class="pt-2">
                            <div class="row">
                                <div class="table-responsive col-sm-12">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Item & Description</th>
                                            <th class="text-right">Rate</th>
                                            <th class="text-right">Hours / Qty</th>
                                            <th class="text-right">Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($invoice->invoiceItems as $idx => $item)
                                            @php
                                                $qty = $item->quantity ?? ($item->hours ?? 1);
                                                $unit = $item->unit_price ?? $item->rate ?? 0;
                                                $lineTotal = $item->total ?? ($qty * $unit);
                                            @endphp
                                            <tr>
                                                <th scope="row">{{ $idx + 1 }}</th>
                                                <td>
                                                    <p>{{ $item->description ?? '—' }}</p>
                                                    @if(!empty($item->notes))
                                                        <p class="text-muted">{{ $item->notes }}</p>
                                                    @endif
                                                </td>
                                                <td class="text-right">
                                                    ${{ number_format($unit, 2) }}{{ isset($item->rate) ? '/hr' : '' }}</td>
                                                <td class="text-right">{{ $qty }}</td>
                                                <td class="text-right">${{ number_format($lineTotal, 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">No items added to this
                                                    invoice.
                                                </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Payment / Totals --}}
                            <div class="row">
                                <div class="col-md-7 col-sm-12 text-center text-md-left">
{{--                                    <p class="lead">Payment Methods:</p>--}}
                                    <div class="row">
                                        <div class="col-md-8">
                                            {{--                                            <table class="table table-borderless table-sm">--}}
                                            {{--                                                <tbody>--}}
                                            {{--                                                <tr>--}}
                                            {{--                                                    <td>Bank name:</td>--}}
                                            {{--                                                    <td class="text-right">{{ $invoice->bank_name ?? 'ABC Bank, USA' }}</td>--}}
                                            {{--                                                </tr>--}}
                                            {{--                                                <tr>--}}
                                            {{--                                                    <td>Acc name:</td>--}}
                                            {{--                                                    <td class="text-right">{{ $invoice->account_name ?? ($companyName) }}</td>--}}
                                            {{--                                                </tr>--}}
                                            {{--                                                <tr>--}}
                                            {{--                                                    <td>IBAN:</td>--}}
                                            {{--                                                    <td class="text-right">{{ $invoice->iban ?? 'FGS165461646546AA' }}</td>--}}
                                            {{--                                                </tr>--}}
                                            {{--                                                <tr>--}}
                                            {{--                                                    <td>SWIFT code:</td>--}}
                                            {{--                                                    <td class="text-right">{{ $invoice->swift ?? 'BTNPP34' }}</td>--}}
                                            {{--                                                </tr>--}}
                                            {{--                                                </tbody>--}}
                                            {{--                                            </table>--}}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-5 col-sm-12">
                                    <p class="lead">Total due</p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <td>Sub Total</td>
                                                <td class="text-right">${{ number_format($invoice->total_amount, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td>TAX (0%)</td>
                                                <td class="text-right">$0.00</td>
                                            </tr>
                                            <tr class="bg-grey bg-lighten-4">
                                                <td class="text-bold-800">Balance Due</td>
                                                <td class="text-bold-800 text-right">
                                                    ${{ number_format($invoice->total_amount, 2) }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="text-center">
                                        <p>Authorized person</p>
                                        {{--                                        <img src="{{ $signature }}" alt="signature" class="height-100" style="max-height:80px;object-fit:contain;" />--}}
                                        <h6>{{ $companyName ?? '—' }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Invoice Footer -->
                        <div id="invoice-footer">
                            <div class="row">
                                <div class="col-md-7 col-sm-12">
{{--                                    <h6>Terms & Condition</h6>--}}
{{--                                    <p>{!! nl2br(e($invoice->terms_and_conditions ?? 'You know, being a test pilot isn\'t always the healthiest business in the world. We predict too much for the next year and yet far too little for the next 10.')) !!}</p>--}}
                                </div>

                                <div class="col-md-5 col-sm-12 text-center">
                                    @if(!$isPdf)
                                        {{-- Show action button only on web view (not in PDF) --}}
{{--                                        <form action="#" method="POST" class="d-inline">--}}
{{--                                            @csrf--}}
{{--                                            <button type="submit" class="btn btn-info btn-lg my-1">--}}
{{--                                                <i class="la la-paper-plane-o"></i> Send Invoice--}}
{{--                                            </button>--}}
{{--                                        </form>--}}
                                        <a href="{{ route('dashboard.invoices.pdf', $invoice) }}"
                                           class="btn btn-secondary btn-lg my-1">Download PDF</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!--/ Invoice Footer -->

                    </div>
                </section>
            </div>
        </div>
    </div>

@endsection
@push('script')




@endpush
