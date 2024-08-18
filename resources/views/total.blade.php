<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .container {
            width: 100%;
            max-width: 300px;
            margin: 0 auto;
            padding: 10px;
            border: 1px dashed #000;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 10px;
        }
        .header h2 {
            margin: 0;
        }
        .content {
            margin-bottom: 10px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .total {
            text-align: right;
            margin-top: 10px;
        }
        .buttons {
            text-align: center;
            margin-top: 20px;
        }
        .buttons button {
            margin: 5px;
            padding: 10px 20px;
            font-size: 14px;
        }
        @media print {
            .buttons {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Check</h2>
            <p>O'yin raqami: {{ $game_number }}</p>
            <p>Boshlanish vaqti: {{ $orders->first()->start_time }}</p>
            <p>Tugash vaqti: {{ $orders->first()->end_time }}</p>
            <p>O'ynagan vaqti:
                @php
                    $start_time = \Carbon\Carbon::parse($orders->first()->start_time);
                    $end_time = \Carbon\Carbon::parse($orders->first()->end_time);
                    $played_time = $end_time->diff($start_time);
                    echo $played_time->format('%H soat %I daqiqa');
                @endphp
            </p>
        </div>

        <div class="content">
            <table class="table">
                <thead>
                    <tr>
                        <th>Mahsulot</th>
                        <th>Miqdor</th>
                        <th>Narxi</th>
                        <th>Jami</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($porders as $porder)
                    <tr>
                        <td>{{ $porder->product->name }}</td>
                        <td>{{ $porder->product_total }}</td>
                        <td>{{ number_format($porder->product_summ/$porder->product_total, 0, ',', ' ') }} so'm</td>
                        <td>{{ number_format($porder->product_summ, 0, ',', ' ') }} so'm</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="total">
                <strong>Buyurtmalar: {{ number_format($porders->sum('product_summ'), 0, ',', ' ') }} so'm</strong><br>
                <hr>
                <strong>O'ynalgan vaqt uchun: {{ number_format($orders->first()->game_summ, 0, ',', ' ') }} so'm</strong>
                <hr>
                <strong style="color: red; font-size: 18px">Jami summa: {{ number_format($porders->sum('product_summ')+$orders->first()->game_summ, 0, ',', ' ') }}</strong>
            </div>
        </div>
        <div class="footer">
            <p>Rahmat!</p>
        </div>
        <div class="buttons">
            <button onclick="window.print(); return false;">Chekni chop etish</button>
            <button onclick="window.location.href='{{ url('/dashboard') }}'">Bosh sahifaga qaytish</button>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.4.4/build/qrcode.min.js"></script>
</body>
</html>
