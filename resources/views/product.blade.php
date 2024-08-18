@extends("components.main")
@section('content')
    <div class="container mt-5">
        <div class="upper-table">
            <h4>Maxsulotlar</h4>
            {{-- Izlash inputi --}}
            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Maxsulot izlash..." onkeyup="filterProducts()">

                <form id="orderForm">
                    @csrf
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">№</th>
                                <th scope="col">Maxsulot nomi</th>
                                <th scope="col">Maxsulot narxi</th>
                                <th scope="col">Maxsulot soni</th>
                                <th scope="col">Tanlash</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $index => $product)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="product-name">{{ $product->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td><input type="number" min="1" name="products[{{ $index }}][quantity]" value="1"></td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $product->id }}" name="products[{{ $index }}][id]" id="product_{{ $product->id }}">
                                            <label class="form-check-label" for="product_{{ $product->id }}">
                                                Tanlash
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            <input type="hidden" name="game_id" value="{{ $id }}">
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-outline-success" onclick="submitOrder()">Buyurtma qilish</button>
                </form>

        </div>
    </div>

    <script>
        function submitOrder() {
            let form = document.getElementById('orderForm');
            let formData = new FormData(form);
            let products = [];
            let rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                let checkbox = row.querySelector('input[type="checkbox"]');
                if (checkbox.checked) {
                    let productId = checkbox.value;
                    let quantity = row.querySelector('input[type="number"]').value;
                    products.push({ id: productId, quantity: quantity });
                }
            });
            let payload = {
                game_id: formData.get('game_id'),
                products: products
            };

            fetch('{{ route("porders.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify(payload)
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(error => {
                        throw new Error(error.message || 'Network response was not ok');
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Success:', data);
                alert('Buyurtma muvaffaqiyatli yuborildi!');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Xatolik yuz berdi, iltimos qaytadan urinib ko\'ring: ' + error.message);
            });
        }

        function filterProducts() {
            let input = document.getElementById('searchInput');
            let filter = input.value.toLowerCase();
            let rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                let productName = row.querySelector('.product-name').textContent.toLowerCase();
                if (productName.indexOf(filter) > -1) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
@endsection
