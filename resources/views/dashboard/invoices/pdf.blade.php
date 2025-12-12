{{-- resources/views/invoices/pdf.blade.php --}}
    <!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $invoice->invoice_number ?? 'Invoice' }}</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        @page {
            margin: 15mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
        }

        /* === PAGE BORDER === */
        .page-border {
            border: 2px solid #000;
            padding: 18px;
            height: 90%;
            box-sizing: border-box;
        }

        /* Layout / Typography */
        .wrapper {
            width: 100%;
        }

        header {
            margin-bottom: 20px;
        }

        .company {
            float: left;
            width: 60%;
        }

        .invoice-meta {
            float: right;
            width: 38%;
            text-align: right;
        }

        .clear {
            clear: both;
        }

        .client-box {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 10px;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 18px;
        }

        table.items thead th {
            border-bottom: 2px solid #444;
            padding: 8px 6px;
        }

        table.items tbody td {
            border-bottom: 1px solid #eee;
            padding: 8px 6px;
        }

        table.totals {
            width: 35%;
            float: right;
            margin-top: 12px;
            border-collapse: collapse;
        }

        table.totals td {
            padding: 6px 8px;
        }

        table.totals tr.total-row td {
            border-top: 2px solid #444;
            font-weight: bold;
        }

        footer {
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 11px;
            color: #777;
        }
    </style>
</head>
<body>
<div class="page-border">
    <div class="wrapper">
        <header>
            <div class="company">
                Company / Seller info (use authenticated user or static)
                <h2>{{ optional($user)->name ?? config('app.name', 'Your Company') }}</h2>
                @if(optional($user)->email)
                    <p>Email: {{ optional($user)->email }}</p>
                @endif
                @if(optional($user)->phone)
                    <p>Phone: {{ optional($user)->phone }}</p>
                @endif
                Optional company address if stored on user model
                @if(optional($user)->address)
                    <p>Address: {{ optional($user)->address }}</p>
                @endif
            </div>

            <div class="invoice-meta">
                <h3>INVOICE</h3>
                <p><strong>Invoice #:</strong> {{ $invoice->invoice_number }}</p>
                <p><strong>Invoice Date:</strong> {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d') }}
                </p>
                @if($invoice->due_date)
                    <p><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($invoice->due_date)->format('Y-m-d') }}</p>
                @endif
            </div>

            <div class="clear"></div>
        </header>

        <section class="client-box">
            <div style="float:left; width:65%;">
                <h4>Bill To:</h4>
                <p><strong>{{ $invoice->client->name }}</strong></p>
                @if($invoice->client->address)
                    <p>{{ $invoice->client->address }}</p>
                @endif
                @if($invoice->client->email)
                    <p>Email: {{ $invoice->client->email }}</p>
                @endif
                @if($invoice->client->phone)
                    <p>Phone: {{ $invoice->client->phone }}</p>
                @endif
            </div>
            <div style="float:right; width:33%; text-align:right;">
                {{-- Small invoice metadata if needed --}}
                <p><strong>Status:</strong> {{ $invoice->status ?? 'Unpaid' }}</p>
            </div>
            <div class="clear"></div>
        </section>

        {{-- Items table --}}
        <table class="items" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
                <th style="width: 52%;">Description</th>
                <th style="width: 12%;">Qty</th>
                <th style="width: 18%;">Unit Price</th>
                <th style="width: 18%;">Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoice->invoiceItems as $item)
                <tr>
                    <td>{{ \Illuminate\Support\Str::limit($item->description, 50) }}</td>
                    <td class="text-right nowrap">{{ $item->quantity }}</td>
                    <td class="text-right nowrap">{{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-right nowrap">{{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{-- Totals --}}
        <table class="totals">
            <tbody>
            <tr>
                <td>Subtotal</td>
                <td class="text-right nowrap">{{ number_format($invoice->invoiceItems->sum('total'), 2) }}</td>
            </tr>

            {{-- If you have tax, discount fields, add here --}}
            @if(isset($invoice->tax) && $invoice->tax > 0)
                <tr>
                    <td>Tax ({{ $invoice->tax }}%)</td>
                    @php
                        $subtotal = $invoice->items->sum('total');
                        $taxAmount = ($subtotal * $invoice->tax) / 100;
                    @endphp
                    <td class="text-right nowrap">{{ number_format($taxAmount, 2) }}</td>
                </tr>
            @else
                @php $taxAmount = 0; $subtotal = $invoice->invoiceItems->sum('total'); @endphp
            @endif

            @if(isset($invoice->discount) && $invoice->discount > 0)
                <tr>
                    <td>Discount</td>
                    <td class="text-right nowrap">-{{ number_format($invoice->discount, 2) }}</td>
                </tr>
            @else
                @php $invoice->discount = $invoice->discount ?? 0; @endphp
            @endif

            <tr class="total-row">
                <td><strong>Total</strong></td>
                @php
                    $calculatedTotal = $subtotal + $taxAmount - ($invoice->discount ?? 0);
                @endphp
                <td class="text-right nowrap"><strong>{{ number_format($calculatedTotal, 2) }}</strong></td>
            </tr>
            </tbody>
        </table>

        <div class="clear"></div>

        @if($invoice->notes)
            <div class="notes">
                <strong>Notes</strong>
                <p>{{ $invoice->notes }}</p>
            </div>
        @endif

        <div style="height:24px;"></div>

        <div style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <p>Prepared by: {{ optional($user)->name ?? '---' }}</p>
            </div>

            <div>
                <p>Signature:</p>
                <div style="width:160px; height:40px; border-bottom:1px solid #000;"></div>
            </div>
        </div>

        <footer>
            {{ config('app.name') }} — Invoice generated on {{ \Carbon\Carbon::now()->format('Y-m-d H:i') }}.
        </footer>
    </div>
</div>
</body>
</html>
