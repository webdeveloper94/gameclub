@extends("components.main")

@section('content')
    <div class="container mt-5">
        <div class="upper-table">
            <h4>Hisobotlar</h4>

            {{-- Filter form --}}
            <form action="{{ route('reports.index') }}" method="GET" class="form-control" id="filter">
                <input type="date" name="start_date" id="" class="form-control">
                <input type="date" name="end_date" id="" class="form-control">
                <input type="submit" value="Filter" class="btn btn-primary mt-2">
            </form>

            {{-- Bo'limlar ro'yxati --}}
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Stol raqami</th>
                        <th>Sana</th>
                        <th>Boshlanish vaqti</th>
                        <th>Tugash vaqti</th>
                        <th>O'yin uchun summa</th>
                        <th>Buyurtmalar uchun summa</th>
                        <th>Jami summa</th>
                        <th>Ko'rish</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grandTotalSum = 0;
                    @endphp
                    @foreach($orders as $order)
                        @php
                            $porderSumm = $order->porders->sum('product_summ');
                            $totalSum = $order->game_summ + $porderSumm;
                            $grandTotalSum += $totalSum;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->game->game_number }}</td>
                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                            <td>{{ $order->start_time }}</td>
                            <td>{{ $order->end_time }}</td>
                            <td>{{ number_format($order->game_summ) }}</td>
                            <td>{{ number_format($porderSumm) }}</td>
                            <td>{{ number_format($totalSum) }}</td>
                            <td><a href="{{ route('show.report', ['id' => $order->id]) }}">
                                <button type="button" class="btn btn-outline-primary">Ko'rish</button>
                            </a></td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="7" class="text-end">Jami summa:</th>
                        <th>{{ number_format($grandTotalSum) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <hr>
    </div>
@endsection
