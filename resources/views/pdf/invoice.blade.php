<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 13px; color: #222; }
        .header { width: 100%; margin-bottom: 30px; }
        .header td { vertical-align: top; }
        h1 { font-size: 20px; margin: 0 0 4px; }
        .muted { color: #666; }
        table.details { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table.details th, table.details td { text-align: left; padding: 8px; border-bottom: 1px solid #ddd; }
        table.details th { background: #f5f5f5; }
        .totals { width: 50%; margin-left: auto; margin-top: 20px; }
        .totals td { padding: 6px 8px; }
        .totals .grand { font-weight: bold; border-top: 2px solid #222; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <table class="header">
        <tr>
            <td>
                <h1>{{ $brand->name }}</h1>
                @if ($brand->legal_name)
                    <div class="muted">{{ $brand->legal_name }}</div>
                @endif
                @if ($brand->address)
                    <div class="muted">{{ $brand->address }}</div>
                @endif
                @if ($brand->business_reg_no)
                    <div class="muted">Reg No: {{ $brand->business_reg_no }}</div>
                @endif
            </td>
            <td class="text-right">
                <h1>INVOICE</h1>
                <div>{{ $invoiceNumber }}</div>
                <div class="muted">{{ $issuedAt->format('d/m/Y') }}</div>
            </td>
        </tr>
    </table>

    <table class="details">
        <tr>
            <th colspan="2">Billed To</th>
        </tr>
        <tr>
            <td>{{ $booking->customer_name }}</td>
            <td>{{ $booking->customer_email }}</td>
        </tr>
        <tr>
            <td>{{ $booking->customer_phone }}</td>
            <td></td>
        </tr>
    </table>

    <table class="details">
        <thead>
            <tr>
                <th>Description</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    {{ $booking->package->name }}<br>
                    <span class="muted">{{ $booking->booking_date->toFormattedDateString() }} — {{ $booking->slotLabel() }}</span>
                </td>
                <td class="text-right">{{ $booking->package->price_cents->format() }}</td>
            </tr>
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td>Package Price</td>
            <td class="text-right">{{ $booking->package->price_cents->format() }}</td>
        </tr>
        <tr class="grand">
            <td>Deposit Paid</td>
            <td class="text-right">{{ $booking->deposit_amount_cents->format() }}</td>
        </tr>
        <tr>
            <td>Balance Due</td>
            <td class="text-right">{{ $booking->package->price_cents->subtract($booking->deposit_amount_cents)->format() }}</td>
        </tr>
    </table>
</body>
</html>
