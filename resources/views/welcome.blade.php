<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YSAN Chatbot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            color: #fff;
        }
        .hero {
            padding: 100px 20px;
            text-align: center;
        }
        .hero img {
            width: 100px;
            height: 100px;
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .feature-box {
            background: #fff;
            color: #333;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: transform .2s;
        }
        .feature-box:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">🤖 YSAN Chatbot</a>
            <div class="ms-auto">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-warning">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-light me-2">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-warning">Register</a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <section class="hero text-center py-5 bg-gradient" style="background: linear-gradient(135deg, #0d6efd, #6610f2); color: white;">
    <img src="https://cdn-icons-png.flaticon.com/512/4712/4712109.png" alt="bot" width="100">
    <h1 class="fw-bold mt-4">Selamat Datang di <span class="text-warning">YSAN Chatbot</span></h1>
    <p class="lead mt-3">Asisten virtual berbasis AI yang siap membantu belajar, bekerja, atau sekadar menemani ngobrol ✨</p>

    <a href="{{ route('login') }}" class="btn btn-warning btn-lg px-4 mt-3 fw-bold">Mulai Sekarang</a>

    <div class="d-flex justify-content-center gap-3 mt-4">
        <a href="https://facebook.com" target="_blank" class="btn btn-light rounded-circle shadow-sm">
            <i class="bi bi-facebook"></i>
        </a>
        <a href="https://instagram.com" target="_blank" class="btn btn-light rounded-circle shadow-sm">
            <i class="bi bi-instagram"></i>
        </a>
        <a href="https://twitter.com" target="_blank" class="btn btn-light rounded-circle shadow-sm">
            <i class="bi bi-twitter"></i>
        </a>
    </div>
</section>

    <section class="container py-5">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="feature-box">
                    <h4>⚡ Cepat & Responsif</h4>
                    <p>Jawaban real-time dengan AI canggih OpenRouter.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-box">
                    <h4>📚 Membantu Belajar</h4>
                    <p>Gunakan chatbot untuk tugas kuliah dan kerja.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-box">
                    <h4>🔒 Aman</h4>
                    <p>Setiap user punya riwayat chat pribadi.</p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
