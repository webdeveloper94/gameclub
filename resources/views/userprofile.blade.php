@extends("components.main")
@section('content')

<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Xabar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Bu yerga muvaffaqiyatli xabar kiritiladi -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @elseif (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Yopish</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript kodi -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if(session('success') || session('error'))
            $('#successModal').modal('show');
        @endif
    });
</script>


<div class="container text-left" style="margin-top: 20px">
    <div class="row align-items-start">
        <div class="col">
            <h4>Shaxsiy ma'lumotlar</h4>
            Ism: {{ $users->name }}<br><br>
            e-mail: {{ $users->email }}<br><br>
            Ro'yhatdan o'tgan sana: {{ $users->created_at->format('d-m-Y') }}<br><br>
            Foydalanuvchi roli: {{ $users->type }}<br><br>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                </svg> Parolni o'zgartirish
            </button>

            <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('user.profile', $users->id) }}">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="changePasswordModalLabel">Parolni o'zgartirish</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">Eski parol</label>
                                    <input type="password" class="form-control" id="new_password" name="old_password" placeholder="Parol kamida 6 belgidan iborat bo'lishi kerak" required>
                                </div>
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">Yangi parol</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Parol kamida 6 belgidan iborat bo'lishi kerak" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Parolni tasdiqlash</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                                <button type="submit" class="btn btn-primary">Saqlash</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <div class="col">
            <h4>To'lovlar jadvali</h4><br>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>To'lov sanasi</th>
                        <th>To'lov Summasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td>{{ $payment->payment_date }}</td>
                        <td>{{ $payment->summa }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination links -->
            {{ $payments->links() }}
            <!-- End pagination links -->

            <a disabled="disabled" href="{{ route('export.excel', ['id' => $users->id]) }}" class="btn btn-outline-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-excel" viewBox="0 0 16 16">
                    <path d="M5.884 6.68a.5.5 0 1 0-.768.64L7.349 10l-2.233 2.68a.5.5 0 0 0 .768.64L8 10.781l2.116 2.54a.5.5 0 0 0 .768-.641L8.651 10l2.233-2.68a.5.5 0 0 0-.768-.64L8 9.219l-2.116-2.54z"/>
                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                </svg> Excel
            </a>
        </div>
        <div class="col">
            <h4>Qarz, ortiqcha to'lov</h4><br>
            @php
                $currentDate = \Carbon\Carbon::now();
                $registrationDate = \Carbon\Carbon::parse($users->created_at);
                $day = $registrationDate->diffInDays($currentDate);
                $totalPayments = $payments->sum('summa');
                $totalday = $totalPayments/7000;
                $kunqarz = number_format($day - $totalday);
                if ($kunqarz>0) {
                    echo "<b style='color: red'>". $kunqarz*7000," Qarz";
                } else {
                    echo  "<b style='color: rgb(17, 155, 79)'>".(-1) * $kunqarz * 7000 . " Ortiqcha";
                }
            @endphp
            <br><br>
            @if (auth()->user()->type == 'admin')
            <form method="POST" action="{{ route('users.destroy', $users->id) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Siz haqiqatdan ham Foydalanuvchini o\'chirmoqchimisiz? Bu amaldan so\'ng ushbu malumotlarni qayta tiklab bo\'lmaydi ')" type="submit" class="btn btn-outline-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6h4a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-1.243l-.856 9.69a2 2 0 0 1-1.994 1.81H5.594a2 2 0 0 1-1.994-1.81L2.744 6.5H1.5a.5.5 0 0 1 0-1h3zM4.118 13.693l.756-8.61A1 1 0 0 1 5.876 4h4.248a1 1 0 0 1 .996.883l.756 8.61a1 1 0 0 1-.996 1.107H5.114a1 1 0 0 1-.996-1.107zM5.5 2.5a1 1 0 1 1 2 0v1h1v-1a1 1 0 1 1 2 0v1h1.5a.5.5 0 0 1 0 1h-9a.5.5 0 0 1 0-1H5.5v-1z"/>
                    </svg> Foydalanuvchini o'chirish
                </button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection
