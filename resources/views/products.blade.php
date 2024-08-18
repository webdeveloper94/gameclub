@extends("components.main")

@section('content')
    <div class="container mt-5">
        <div class="upper-table">
            <h4>Mavjud maxsulotlar</h4>

            {{-- Yangi maxsulot qo'shish tugmasi --}}
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSectionModal">
                Yangi maxsulot qo'shish
            </button>

            {{-- Maxsulotlar ro'yxati --}}
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Maxsulot nomi</th>
                        <th>Narxi</th>
                        <th>Soni</th>
                        <th>Tahrirlash</th>
                        <th>O'chirish</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->total }}</td>
                            <td>
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#editSectionModal{{ $product->id }}">
                                    Tahrirlash
                                </button>
                                {{-- Tahrirlash uchun modal oyna --}}
                                <div class="modal fade" id="editSectionModal{{ $product->id }}" tabindex="-1" aria-labelledby="editSectionModalLabel{{ $product->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editSectionModalLabel{{ $product->id }}">Maxsulotni tahrirlash</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('products.update', $product->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label for="edit_name">Maxsulot nomi</label>
                                                        <input type="text" class="form-control" id="edit_name" name="name" value="{{ $product->name }}" required>
                                                        <label for="edit_price">Maxsulot narxi</label>
                                                        <input type="number" class="form-control" id="edit_price" name="price" value="{{ $product->price }}" required>
                                                        <label for="edit_total">Maxsulot soni</label>
                                                        <input type="number" class="form-control" id="edit_total" name="total" value="{{ $product->total }}" required>
                                                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Yopish</button>
                                                        <button type="submit" class="btn btn-primary">Saqlash</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td> <a href="{{ route('products.show', ['product' => $product->id])}}"><button type="button" class="btn btn-outline-danger">O'chirish</button></a> </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <hr>
    </div>

    {{-- Yangi maxsulot qo'shish modal oynasi --}}
    <div class="modal fade" id="addSectionModal" tabindex="-1" aria-labelledby="addSectionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSectionModalLabel">Yangi maxsulot qo'shish</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Maxsulot nomi</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <label for="price">Maxsulot narxi</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                            <label for="total">Maxsulot soni</label>
                            <input type="number" class="form-control" id="total" name="total" required>
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Yopish</button>
                            <button type="submit" class="btn btn-primary">Saqlash</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
