@extends("admin.main")
@section('content')

<div class="container mt-5">
    <div class="upper-table">
        <h4>Barcha foydalanuvchilar</h4>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            Foydalanuvchi qo'shish
        </button>
        {{-- ADD user modal --}}
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addUserModalLabel">Foydalanuvchi qo'shish</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Ism</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Telefon</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="+998 99 444 55 88" maxlength="17">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Parol</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Parolni tasdiqlash</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
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



        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ism</th>
                    <th>E-mail</th>
                    <th>Roli</th>
                    <th>Oxirgi to'lov</th>
                    <th>Summasi</th>
                    <th>Qarz</th>
                    <th>Holati</th>
                    <th>To'lov olish</th>
                    <th>Tahrirlash</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->type }}</td>

                    @php
                        $lastPayment = $user->last_payment;
                    @endphp
                    <td>{{ $lastPayment ? \Carbon\Carbon::parse($lastPayment->payment_date)->format('d-m-Y') : 'No payment' }}</td>
                    <td>{{ $lastPayment ? number_format($lastPayment->summa, 0, ',', ' ') . ' so\'m' : 'No payment' }}</td>
                    <td>
                        @php
                            $currentDate = \Carbon\Carbon::now();
                            $registrationDate = \Carbon\Carbon::parse($user->created_at);
                            $day = $registrationDate->diffInDays($currentDate);
                            $totalPayments = $user->payments->sum('summa');
                            $totalday = $totalPayments/7000;
                            $kunqarz = number_format($day - $totalday);
                            if ($kunqarz>0) {
                                echo "<b style='color: red'>". $kunqarz*7000," Qarz";
                            } else {
                                echo  "<b style='color: rgb(17, 155, 79)'>".(-1) * $kunqarz * 7000 . " Ortiqcha";
                            }
                        @endphp
                    </td>
                    <td>
                        @if ($user->type == 'user' || $user->type == 'admin')
                            {{ 'Aktiv' }}
                        @endif
                        @if ($user->type == 'blok')
                            {{ 'Bloklangan' }}
                        @endif
                    </td>
                    <td>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#paymentModal" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">To'lov olish</button>
                    </td>
                    <td>
                        <a href="{{ route('users.show', ['user' => $user->id]) }}">
                        <button type="button" class="btn btn-outline-success">Ko'rish</button>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('payments.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">To'lov olish</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="modalUserId">
                    <div class="mb-3">
                        <label for="modalUserName" class="form-label">Foydalanuvchi</label>
                        <input type="text" class="form-control" id="modalUserName" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="summa" class="form-label">Summa</label>
                        <input type="number" class="form-control" id="summa" name="summa" required>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const phoneInput = document.getElementById('phone');

    // Dastlabki +998 ni o'rnatish
    phoneInput.value = "+998 ";

    phoneInput.addEventListener('input', function(e) {
        let value = phoneInput.value;

        // Faqat raqamlar va bo'sh joyni qoldirish
        value = value.replace(/[^\d\s]/g, '');

        // +998 ni o'chirishga yo'l qo'ymaslik
        if (!value.startsWith("998")) {
            value = "998" + value;
        }

        // +998 formatida ko'rinish
        if (value.length >= 3) {
            value = value.replace(/(\d{3})(\d{2})(\d{3})(\d{2})(\d{2})/, "+998 $2 $3 $4 $5");
        } else {
            value = "+998 " + value.substring(3);
        }

        phoneInput.value = value;
    });
});

</script>


<script>
    var paymentModal = document.getElementById('paymentModal');
    paymentModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var userId = button.getAttribute('data-user-id');
        var userName = button.getAttribute('data-user-name');

        var modalUserId = paymentModal.querySelector('#modalUserId');
        var modalUserName = paymentModal.querySelector('#modalUserName');

        modalUserId.value = userId;
        modalUserName.value = userName;
    });
</script>

<script>
    // Parolni tasdiqlashni tekshirish
    var password = document.getElementById("password");
    var confirm_password = document.getElementById("password_confirmation");

    function validatePassword() {
        if (password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Parollar mos kelmadi");
        } else {
            confirm_password.setCustomValidity('');
        }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
</script>

<script>
    // Modal oynaning ochilishi
    var addUserModal = new bootstrap.Modal(document.getElementById('addUserModal'), {
        keyboard: false
    });

    // Modal oynaning tarkibi yuklandiğida
    addUserModal.show();
</script>

@endsection
