<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body { font-family: Arial; font-size: 14px; }
        .header { text-align: center; margin-bottom: 20px; }
        .total { font-size: 18px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 8px; border-bottom: 1px solid #ddd; }
    </style>
</head>
<body>

<div class="header">
    <h2>Hotel Invoice</h2>
    <small>Reservation #{{ $reservation->id }}</small>
</div>

<table>
    <tr>
        <td><strong>Guest</strong></td>
        <td>{{ $reservation->guest->full_name }}</td>
    </tr>
    <tr>
        <td><strong>Room</strong></td>
        <td>Room {{ $reservation->room->room_number }}</td>
    </tr>
    <tr>
        <td><strong>Stay</strong></td>
        <td>
            {{ $reservation->stayDetail->check_in_date->format('d M Y') }}
            →
            {{ $reservation->stayDetail->check_out_date->format('d M Y') }}
        </td>
    </tr>
</table>

<br>

<table>
    <thead>
        <tr>
            <th>Description</th>
            <th align="right">Amount</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $reservation->stayDetail->no_of_nights }} Nights</td>
            <td align="right">{{ number_format($reservation->stayDetail->total_price, 2) }}</td>
        </tr>
        <tr>
            <td>Advance Paid</td>
            <td align="right">- {{ number_format($reservation->stayDetail->advance_payment, 2) }}</td>
        </tr>
    </tbody>
</table>

<p class="total">
    Balance: {{ number_format($reservation->stayDetail->balance, 2) }}
</p>

</body>
</html>
