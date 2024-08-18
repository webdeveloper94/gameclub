@extends("components.main")

@section('content')
    <div class="container mt-5">
        <div class="upper-table">
            <h4>Mavjud O'yinlar</h4>

            {{-- Yangi o'yin qo'shish tugmasi --}}
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addGameModal">
                Yangi o'yin qo'shish
            </button>

            {{-- o'yinlar --}}
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>O'yin raqami</th>
                        <th>Narxi</th>
                        <th>Turi</th>
                        <th>Tahrirlash</th>
                        <th>O'chirish</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($games as $game)
                        <tr>
                            <td>{{ $game->id }}</td>
                            <td>{{ $game->game_number }}</td>
                            <td>{{ $game->price }}</td>
                            <td>{{ $game->game_type }}</td>
                            <td><button type="button" class="btn btn-outline-primary">Tahrirlash</button></td>
                            <td>
                                <form action="{{ route('viewgames.destroy', $game->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('O\'yin o\'chirilishi haqiqatdan ham?')">O'chirish</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <hr>
    </div>

    {{-- Modal oyna --}}
    <div class="modal fade" id="addGameModal" tabindex="-1" aria-labelledby="addGameModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGameModalLabel">Yangi o'yin qo'shish</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('viewgames.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="game_number">O'yin raqami</label>
                            <input type="text" class="form-control" id="game_number" name="game_number" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Narxi</label>
                            <input type="text" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="game_type">Turi</label>
                            <select id="game_type" name="game_type" class="form-control" required>
                                <option value=""></option>
                                @foreach ($sections as $section)
                                    <option value="{{ $section->section_name }}">{{ $section->section_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
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
