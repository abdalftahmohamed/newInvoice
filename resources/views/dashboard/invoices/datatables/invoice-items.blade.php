@foreach ($invoice->invoiceItems as $item)
    <div class="d-flex">
        <div class="badge border-primary primary badge-border mx-1">
            {{ $item->unit_price }}
        </div>
        <div class="badge border-primary primary badge-border mx-1">
            {{ $item->quantity }}
        </div>
        <div class="badge border-primary primary badge-border mx-1">
            {{ $item->total }}
        </div>
    </div>
@endforeach
