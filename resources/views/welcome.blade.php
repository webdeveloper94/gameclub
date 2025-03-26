<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bosh sahifa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: black;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        .btn-glass {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            backdrop-filter: blur(10px);
            padding: 10px 20px;
            border-radius: 10px;
            color: white;
            font-size: 1.2rem;
            transition: 0.3s;
        }
        .btn-glass:hover {
            background: rgba(255, 255, 255, 0.4);
        }
    </style>
</head>
<body>
    <canvas id="starCanvas"></canvas>
    <h1>O'yin klubingizni avtomatlashtiring</h1>
    <p>Bizning platforma orqali oson boshqaruv va nazorat!</p>
    <button class="btn btn-glass">
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}" style="text-decoration: none; color: white;">Sahifaga kirish</a>
            @else
                <a href="{{ route('login') }}" style="text-decoration: none; color: white;">Sahifaga kirish</a>
            @endauth
        @endif
    </button>
    
    <script>
        const canvas = document.getElementById('starCanvas');
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        let stars = [];
        const numStars = 100;

        class Star {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.speed = Math.random() * 3 + 1;
                this.size = Math.random() * 2;
            }
            draw() {
                ctx.fillStyle = "white";
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
            }
            update() {
                this.x -= this.speed;
                if (this.x < 0) {
                    this.x = canvas.width;
                    this.y = Math.random() * canvas.height;
                }
                this.draw();
            }
        }

        function init() {
            for (let i = 0; i < numStars; i++) {
                stars.push(new Star());
            }
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            stars.forEach(star => star.update());
            requestAnimationFrame(animate);
        }

        init();
        animate();
    </script>
</body>
</html>
