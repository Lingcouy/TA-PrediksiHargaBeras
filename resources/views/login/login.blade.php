<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> Login </title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="container">
        <input type="checkbox" id="flip">
        <div class="cover">
            <div class="front">
                <img src="{{ asset('image/rice-bg.png') }}" alt="">
                <div class="text">
                    <span class="text-1">Prediksi Harga Beras<br> Regresi Linier</span>
                </div>
            </div>
            <div class="back">
                <div class="text">
                    <img src="{{ asset('image/rice-bg.png') }}" alt="">
                    <div class="text">
                        <span class="text-1">Prediksi Harga Beras<br> Regresi Linier</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="forms">
            <div class="form-content">
                <div class="login-form">
                    <div class="title">Masuk</div>
                    <form action="{{ route('login') }}" method="POST"> <!-- Perbaiki action -->
                        @csrf
                        <div class="input-boxes">
                            {{-- @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif --}}

                            <div class="input-box">
                                <i class="fas fa-user"></i>
                                <input type="text" name="username" placeholder="Masukkan Username" required>
                            </div>
                            <div class="input-box">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="password" placeholder="Masukkan Password" required>
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li style="color: red; list-style-type: none;">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="button input-box">
                                <input type="submit" value="Submit">
                            </div>

                            <div class="text sign-up-text">
                                <a href="{{ route('dashboard') }}" style="text-decoration: none; color: #007bff;">
                                    Masuk sebagai pengguna biasa
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
