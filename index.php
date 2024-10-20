<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Landing Page - Rental Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .hero {
            background: url('https://via.placeholder.com/1920x1080?text=Car+Rental') no-repeat center center;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.7);
        }
        .hero h1 {
            font-size: 4rem;
        }
        .hero p {
            font-size: 1.5rem;
        }
        .btn-custom {
            padding: 10px 30px;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>

<!-- Hero Section -->
<div class="hero">
    <div class="text-center">
        <h1>Selamat Datang di Rental Mobil</h1>
        <p>Sewa mobil dengan mudah, aman, dan cepat</p>
        <a href="login.php" class="btn btn-primary btn-custom">Login</a>
        <a href="register.php" class="btn btn-outline-light btn-custom">Registrasi</a>
    </div>
</div>

<!-- About Us Section -->
<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <h2>Tentang Kami</h2>
            <p>Kami adalah penyedia layanan rental mobil yang terpercaya dengan berbagai pilihan mobil berkualitas dan harga terjangkau. Dengan sistem kami yang modern, Anda dapat memesan mobil kapan saja dan di mana saja.</p>
        </div>
        <div class="col-md-6">
            <img src="https://via.placeholder.com/600x400?text=Mobil+Rental" class="img-fluid" alt="Rental Mobil">
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="container my-5">
    <div class="row text-center">
        <div class="col-md-4">
            <img src="https://via.placeholder.com/100?text=Icon" alt="Kecepatan" class="mb-3">
            <h3>Pelayanan Cepat</h3>
            <p>Kami menyediakan layanan cepat dan efisien, memastikan proses sewa mobil berjalan lancar.</p>
        </div>
        <div class="col-md-4">
            <img src="https://via.placeholder.com/100?text=Icon" alt="Aman" class="mb-3">
            <h3>Keamanan Terjamin</h3>
            <p>Semua mobil kami dirawat dengan baik dan dilengkapi dengan asuransi untuk keamanan Anda.</p>
        </div>
        <div class="col-md-4">
            <img src="https://via.placeholder.com/100?text=Icon" alt="Harga Terjangkau" class="mb-3">
            <h3>Harga Terjangkau</h3>
            <p>Kami menawarkan harga yang kompetitif dengan kualitas layanan terbaik di kelasnya.</p>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-4">
    <p>&copy; 2024 Rental Mobil. All Rights Reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
