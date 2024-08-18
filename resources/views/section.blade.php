@extends("components.main")

@section('content')
    <div class="container mt-5">
        <div class="upper-table">
            <h4>Mavjud bo'limlar</h4>

            {{-- Yangi bo'lim qo'shish tugmasi --}}
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSectionModal">
                Yangi bo'lim qo'shish
            </button>

            {{-- Bo'limlar ro'yxati --}}
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Bo'lim nomi</th>
                        <th>Harakatlar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sections as $section)
                        <tr>
                            <td>{{ $section->id }}</td>
                            <td>{{ $section->section_name }}</td>
                            <td>
                                <form action="{{ route('sections.destroy', $section->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Siz haqiqatdan ham bo\'limni o\'chirmoqchimisiz?')">O'chirish</button>
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
    <div class="modal fade" id="addSectionModal" tabindex="-1" aria-labelledby="addSectionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSectionModalLabel">Yangi bo'lim qo'shish</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('sections.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="section_name">Bo'lim nomi</label>
                            <input type="text" class="form-control" id="section_name" name="section_name" required>
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
