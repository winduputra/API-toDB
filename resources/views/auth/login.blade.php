@extends('layouts.tailwind')

@section('content')
<style>
    body {
    background-color: #f4f6fa;
    font-family: 'Poppins', sans-serif;
}

.login-container {
    display: flex;
    min-height: 100vh;
}

/* Panel Kiri */
.left-panel {
    flex: 6;
    background-color: #2b529a;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    padding: 50px;
    color: #fff;
    position: relative;
    overflow: hidden;
    box-shadow: 5px 0 15px rgba(0, 0, 0, 0.1);
}

/* Ornamen Lampung di atas (20%) */
.left-panel::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 20%;

    background-size: cover;
    background-position: center;
    z-index: 0;
}

/* Konten tetap di atas ornamen */
.left-panel > * {
    position: relative;
    z-index: 1;
}

/* Logo */
.logo-wrapper {
    margin-bottom: 30px;
}

/* Konten teks & tombol ditengah panel */
.content-wrapper {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.left-panel h1 {
    font-size: 3rem;
    font-weight: bold;
    margin-bottom: 20px;
}

.left-panel p {
    font-size: 1.1rem;
    max-width: 80%;
    line-height: 1.6;
    margin-bottom: 30px;
}

.left-panel .btn-learn {
    border: 2px solid #fff;
    padding: 10px 30px;
    border-radius: 50px;
    text-transform: uppercase;
    color: white;
    transition: background 0.3s, color 0.3s;
}

.left-panel .btn-learn:hover {
    background: white;
    color: #2b529a;
}

/* Panel Kanan */
.right-panel {
    flex: 4;
    background: white;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px;
}

.login-form {
    width: 100%;
    max-width: 400px;
    text-align: center;
}

.login-form h2 {
    font-size: 2.2rem;
    font-weight: bold;
    margin-bottom: 10px;
}

.login-form p {
    color: #666;
    margin-bottom: 30px;
}

.login-form .form-group {
    position: relative;
    margin-bottom: 20px;
}

.login-form .form-group input {
    width: 100%;
    padding: 12px 20px 12px 45px;
    border: 1px solid #ccc;
    border-radius: 50px;
    font-size: 1rem;
}

.login-form .form-group .icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #999;
}

.login-form button {
    background-color: #2b529a;
    color: white;
    border: none;
    border-radius: 50px;
    width: 100%;
    padding: 12px;
    font-size: 1.1rem;
    transition: background 0.3s;
}

.login-form button:hover {
    background-color: #24467e;
}

.login-form a {
    display: block;
    text-align: center;
    margin-top: 15px;
    color: #666;
    font-size: 0.95rem;
}
/* Tambahan Responsive */
@media (max-width: 1024px) {
    .left-panel h1 {
        font-size: 2.2rem;
    }

    .left-panel p {
        font-size: 1rem;
        max-width: 100%;
    }
}

@media (max-width: 768px) {
    .login-container {
        flex-direction: column;
    }

    .left-panel,
    .right-panel {
        flex: none;
        width: 100%;
        padding: 30px;
    }

    .left-panel {
        align-items: center;
        text-align: center;
    }

    .left-panel h1 {
        font-size: 2rem;
    }

    .left-panel p {
        font-size: 0.95rem;
    }

    .left-panel .btn-learn {
        margin: 0 auto;
    }

    .login-form {
        max-width: 100%;
    }
}

</style>

<div class="login-container">
    <div class="left-panel">
        <img src="{{ url('logo.png') }}" alt="SIBAJA Logo" style="width: 80px; margin-bottom: 20px;">
        <h1>SIBAJA</h1>
        <p>Sistem Informasi Pengadaan Barang & Jasa (SIBAJA) adalah platform inovatif untuk mempercepat, mempermudah, dan meningkatkan transparansi pengadaan. Pantau seluruh tahapan mulai dari perencanaan hingga penyelesaian proyek secara efisien.</p>
    </div>

    <div class="right-panel">
        <form class="login-form" method="POST" action="{{ route('login') }}">
            @csrf
            <h2>Selamat Datang!</h2>
            <p>Silakan login untuk melanjutkan</p>

            <div class="form-group">
                <span class="icon fas fa-user"></span>
                <input type="text" name="username" placeholder="Username" required autofocus>
            </div>
            <div class="form-group">
                <span class="icon fas fa-lock"></span>
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit">Login</button>
        </form>
    </div>
</div>
@endsection
