@extends("components.main")
@section('content')
    <div class="container mt-5">
        <div class="upper-table">
            <h4>Bo'sh stol va xonalar</h4>
            <div class="scrollable-table">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">O'yin raqami</th>
                            <th scope="col">O'yin turi</th>
                            <th scope="col">Narxi</th>
                            <th scope="col">summa</th>
                            <th scope="col">Ochish</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($games as $game)
                        @if ($game->status == 'yopiq')
                        <tr>
                            <td>{{ $game->game_number }}</th>
                            <td>{{ $game->game_type }}</td>
                            <td>{{ number_format($game->price) }}</td>
                            <form class="form-control" action="{{ route('games.update', ['game' => $game->id])}}" method="POST">
                                @csrf
                                @method('PUT')
                            <input type="hidden" name="id" value="{{ $game->id }}">
                            <td><input name="summa" type="number" min="1000"></td>
                            <td><input type="submit" onclick="return confirm('Siz haqiqatdan ham buyurtmani ochmoqchimisiz?')" value="Ochish" class="btn btn-outline-primary"></td>
                            </form>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
<hr>
        <div class="lower-table">
            <h4>Band stol va xonalar</h4>
            <div class="scrollable-table">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">O'yin raqami</th>
                            <th scope="col">O'yin turi</th>
                            <th scope="col">Boshlanish vaqti</th>
                            <th scope="col">Tugash vaqti</th>
                            <th>Qolgan vaqt</th>
                            <th>Buyurtma</th>
                            <th scope="col">Ko'rish</th>
                            <th scope="col">Yopish</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($games as $game)
                        @if ($game->status == 'ochiq')
                        <tr>
                            <td>{{ $game->game_number }}</th>
                            <td>{{ $game->game_type }}</td>
                            <td><span class="start_time">{{ $game->start_time }}</span></td>
                            <td><span class="end_time">{{ $game->end_time }}</span></td>
                            <td><div class="timer"></div></td>
                            <td><a href="{{ route('porders.show', ['porder' => $game->id]) }}" class="btn btn-primary">Buyurtma berish</a></td>
                            <td><a href="{{ route('closes.show', ['close' => $game->id]) }}" class="btn btn-outline-success">Ko'rish</a></td>
                            <form action="{{ route('closes.update', ['close' => $game->id])}}" method="POST">
                                @csrf
                                @method('PUT')
                            <input type="hidden" name="id" value="{{ $game->id }}">
                            <td><input onclick="return confirm('Siz haqiqatdan ham buyurtmani yopmoqchimisiz?')" type="submit" value="Yopish" class="btn btn-outline-danger"></td>
                            </form>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var endTimes = document.querySelectorAll('.end_time');
            var startTimes = document.querySelectorAll('.start_time');
            var timers = document.querySelectorAll('.timer');
            var audio = new Audio('/music/3.mp3');

            function playMusic() {
                audio.currentTime = 0;
                audio.play().catch(error => {
                    console.log("Audio playback failed: " + error);
                });
            }

            function updateTimers() {
                endTimes.forEach(function(endTimeElement, index) {
                    var endTimeStr = endTimeElement.textContent.trim();
                    var startTimeStr = startTimes[index].textContent.trim();
                    var endTime = moment(endTimeStr, 'HH:mm:ss');
                    var startTime = moment(startTimeStr, 'HH:mm:ss');

                    if (!endTime.isValid() || !startTime.isValid()) {
                        timers[index].innerHTML = 'Vaqt formati noto\'g\'ri';
                        return;
                    }

                    var currentTime = moment();

                    // If the end time is before the start time, it means it is on the next day
                    if (endTime.isBefore(startTime)) {
                        endTime.add(1, 'day');
                    }

                    var timeDiff = moment.duration(endTime.diff(currentTime));

                    if (timeDiff.asSeconds() <= 0) {
                        timers[index].innerHTML = '<strong style="color: red;">Tugatildi</strong>';
                        playMusic();
                    } else {
                        timers[index].innerHTML = timeDiff.hours() + ' soat, ' + timeDiff.minutes() + ' daqiqa, ' + timeDiff.seconds() + ' soniya';
                    }
                });
            }

            // Play music when the page loads if any timer is already expired
            setTimeout(() => {
                endTimes.forEach((endTimeElement, index) => {
                    var endTimeStr = endTimeElement.textContent.trim();
                    var startTimeStr = startTimes[index].textContent.trim();
                    var endTime = moment(endTimeStr, 'HH:mm:ss');
                    var startTime = moment(startTimeStr, 'HH:mm:ss');

                    if (!endTime.isValid() || !startTime.isValid()) {
                        return;
                    }

                    var currentTime = moment();

                    // If the end time is before the start time, it means it is on the next day
                    if (endTime.isBefore(startTime)) {
                        endTime.add(1, 'day');
                    }

                    var timeDiff = moment.duration(endTime.diff(currentTime));

                    if (timeDiff.asSeconds() <= 0) {
                        playMusic();
                    }
                });
            }, 1000);

            updateTimers();
            setInterval(updateTimers, 1000);
        });
    </script>
@endsection
