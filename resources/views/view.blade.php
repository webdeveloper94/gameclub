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
            <p>Tugash vaqti: {{ $end_time }}</p>
            <p>O'ynagan vaqti:
                @php
                    $start_time = \Carbon\Carbon::parse($orders->first()->start_time);
                    $end_time = \Carbon\Carbon::parse($end_time);
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
                        <th class="cancel-column" style="display:none;">Bekor qilish</th>
                    </tr>
                </thead>
                <tbody id="porders-table">
                    @foreach ($porders as $porder)
                    <tr>
                        <td>{{ $porder->product->name }}</td>
                        <td>{{ $porder->product_total }}</td>
                        <td>{{ number_format($porder->product_summ/$porder->product_total, 0, ',', ' ') }} so'm</td>
                        <td>{{ number_format($porder->product_summ, 0, ',', ' ') }} so'm</td>
                        <td class="cancel-column" style="display:none;">
                            <input type="checkbox" class="cancel-checkbox" value="{{ $porder->id }}">
                            @if ($porder->product_total > 1)
                                <input type="number" class="cancel-quantity" value="{{ $porder->product_total }}" min="1" max="{{ $porder->product_total }}">
                            @endif
                        </td>
                    @endforeach
                </tbody>
            </table>
            <div class="buttons">
                <button id="cancel-button" style="display:none;" onclick="cancelOrders()">Bekor qilish</button>
            </div>
            <div class="total">
                <strong>Buyurtmalar: {{ number_format($porders->sum('product_summ'), 0, ',', ' ') }} so'm</strong><br>
                <hr>
                <strong>O'ynalgan vaqt uchun: {{ number_format(-$hours_diff*$price, 0, ',', ' ') }} so'm</strong>
                <hr>
                <strong style="color: red; font-size: 18px">Jami summa: {{ number_format($porders->sum('product_summ')+-$hours_diff*$price, 0, ',', ' ') }}</strong>
            </div>
        </div>
        <div class="footer">
            <p>Rahmat!</p>
        </div>
        <div class="buttons">
            <button onclick="window.location.href='{{ url('/dashboard') }}'">Bosh sahifaga qaytish</button>
            <button onclick="showCancelOptions()">Biror bir buyurtmani bekor qilish</button>
            <button id="cancel-button" style="display:none;" onclick="cancelOrders()">Bekor qilish</button>
        </div>
    </div>
    <script>
        function showCancelOptions() {
            document.querySelectorAll('.cancel-column').forEach(function(column) {
                column.style.display = 'table-cell';
            });
            document.getElementById('cancel-button').style.display = 'inline-block';
        }

        function cancelOrders() {
            var selected = [];
            document.querySelectorAll('.cancel-checkbox:checked').forEach(function(checkbox) {
                var quantityInput = checkbox.nextElementSibling;
                var quantity = quantityInput ? quantityInput.value : 1;
                selected.push({ id: checkbox.value, quantity: quantity });
            });

            fetch('{{ route("porder.cancel") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ orders: selected })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    selected.forEach(order => {
                        var row = document.querySelector(`.cancel-checkbox[value="${order.id}"]`).closest('tr');
                        var totalCell = row.querySelector('.product-total');
                        if (totalCell && order.quantity < totalCell.textContent) {
                            totalCell.textContent -= order.quantity;
                        } else {
                            row.remove();
                        }
                    });
                    document.querySelectorAll('.cancel-column').forEach(function(column) {
                        column.style.display = 'none';
                    });
                    document.getElementById('cancel-button').style.display = 'none';
                } else {
                    alert('Bekor qilish uchun maxsulot tanlanmagan');
                }
            });
        }
    </script>
</body>
</html>
