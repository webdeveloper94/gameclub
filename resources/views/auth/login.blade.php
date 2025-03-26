<x-guest-layout>
    <style>
        body {
            margin: 0;
            overflow: hidden;
            background: linear-gradient(to right, #0f0c29, #302b63, #24243e);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 2rem;
            border-radius: 12px;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 100%;
            max-width: 400px;
            color: black;
            position: relative;
        }

        .login-container h2 {
            font-size: 2rem;
            font-weight: bold;
            color: #FFD700;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: none;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 16px;
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 16px;
            border: none;
            border-radius: 6px;
            background: #FFD700;
            color: black;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #ffc107;
        }
    </style>

    <canvas id="stars"></canvas>

    <div class="login-container">
        <h2>Game Clubga Xush Kelibsiz</h2>
        <p class="text-sm text-gray-300">Hisobingizga kirish uchun ma'lumotlarni kiriting</p>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div>
                <input id="email" type="email" name="email" style="color: black;" :value="old('email')" required autofocus autocomplete="username" placeholder="E-mail manzilingiz">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
            </div>

            <div>
                <input id="password" type="password" name="password" style="color: black;" required autocomplete="current-password" placeholder="Parolingiz">
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
            </div>

            <button type="submit">Kirish</button>
        </form>
    </div>

    <script>
        const canvas = document.getElementById("stars");
        const ctx = canvas.getContext("2d");

        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        let stars = [];

        function Star() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height;
            this.radius = Math.random() * 2;
            this.dy = Math.random() * 0.5 + 0.2;
        }

        Star.prototype.update = function() {
            this.y += this.dy;
            if (this.y > canvas.height) {
                this.y = 0;
                this.x = Math.random() * canvas.width;
            }
        };

        Star.prototype.draw = function() {
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
            ctx.fillStyle = "#fff";
            ctx.fill();
        };

        function initStars() {
            for (let i = 0; i < 100; i++) {
                stars.push(new Star());
            }
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            stars.forEach(star => {
                star.update();
                star.draw();
            });
            requestAnimationFrame(animate);
        }

        initStars();
        animate();
    </script>
</x-guest-layout>
