<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} | Test</title>

    <!-- Google Font: Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Importmap untuk Material Design Components -->
    <script type="importmap">
        {
            "imports": {
                "@material/web/": "https://esm.run/@material/web/"
            }
        }
    </script>

    <!-- Inisialisasi Material Design Components -->
    <script type="module">
        import '@material/web/all.js';
        import {styles as typescaleStyles} from '@material/web/typography/md-typescale-styles.js';

        document.adoptedStyleSheets.push(typescaleStyles.styleSheet);
    </script>

    <style>
        :root {
            --md-sys-color-primary: #007bff; /* Warna biru untuk komponen */
            --md-sys-color-on-primary: #ffffff;
        }
        .button {
            width: 100%;
            background-color: var(--md-sys-color-primary);
            border-color: var(--md-sys-color-primary);
            color: var(--md-sys-color-on-primary);
            font-weight: bold;
        }

        body {
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }

        .login-container {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: transparent; /* Transparan agar gambar menyatu dengan background */
        }

        .login-illustration {
            flex: 1.5;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-illustration dotlottie-player {
            width: 100%;
            height: auto;
            margin-right: 40px;
        }

        .login-form-container {
            flex: 1;
            padding-left: 35px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-left: 1px solid #ccc; /* Tambahkan pembatas antara gambar dan form */
        }

        .login-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-header h1 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .login-form {
            margin-top: 20px;
        }

        .login-form md-outlined-text-field {
            margin-bottom: 20px;
            width: 100%;
        }

        .login-form .btn-primary {
            width: 100%;
            background-color: var(--md-sys-color-primary);
            border-color: var(--md-sys-color-primary);
            color: var(--md-sys-color-on-primary);
            font-weight: bold;
        }

        .login-ui {
            width: 900px;
        }

        @media (max-width: 768px) {
            .login-ui {
                margin-top: .5rem;
                width: 100%; /* Memastikan form memenuhi layar di device kecil */
                padding: 0 10px; /* Tambahkan padding pada layar kecil */
            }

            .login-container {
                flex-direction: column;
            }

            .login-illustration,
            .login-form-container {
                width: 100%;
                border-left: none; /* Hapus pembatas pada layar kecil */
                padding: 10px; /* Tambahkan padding pada layar kecil */
            }
        }

        .forgot-password-link {
            text-align: left;
            margin-bottom: 20px;
        }

        .forgot-password-link a {
            color: var(--md-sys-color-primary);
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>

<body>

    @include('sweetalert::alert')

    <div class="login-ui">
        <div class="login-container">
            <div class="login-illustration">
                <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
                <dotlottie-player src="https://lottie.host/51fec9ea-02c6-4124-8ef5-3b5fb19a82d2/RYgZS0fSgU.json" background="transparent" speed="1" loop autoplay></dotlottie-player>
            </div>
            <div class="login-form-container">
                <div class="login-header">
                    <h1>Login</h1>
                </div>
                <div class="login-form">
                <form class="needs-validation" novalidate action="{{ route('login') }}" method="POST" id="loginForm">
                    @csrf
                    <md-outlined-text-field label="Email" type="email" name="email" required></md-outlined-text-field>
                
                    <md-outlined-text-field label="Password" type="password" name="password" required></md-outlined-text-field>
                
                    <div class="row">
                        <div class="col-8">
                            <md-checkbox id="remember"></md-checkbox> Remember Me
                        </div><br>
                        <div class="forgot-password-link">
                            <a href="{{ route('password.request') }}">Lupa Password?</a>
                        </div>
                        <div class="col-4">
                        <md-filled-button class="button" type="submit">Sign In</md-filled-button>
                        </div>

                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                this.submit();
            }
        });
    </script>

    <!-- jQuery -->
    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/assets/dist/js/adminlte.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
