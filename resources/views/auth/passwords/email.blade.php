<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password | Test</title>

    <!-- Google Font: Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Importmap for Material Design Components -->
    <script type="importmap">
        {
            "imports": {
                "@material/web/": "https://esm.run/@material/web/"
            }
        }
    </script>

    <!-- Initialize Material Design Components -->
    <script type="module">
        import '@material/web/all.js';
        import {styles as typescaleStyles} from '@material/web/typography/md-typescale-styles.js';

        document.adoptedStyleSheets.push(typescaleStyles.styleSheet);
    </script>

    <style>
        :root {
            --md-sys-color-primary: #007bff; /* Blue color for components */
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

        .reset-container {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: transparent;
        }

        .reset-form-container {
            flex: 1;
            padding: 35px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        .reset-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .reset-header h1 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .reset-form {
            margin-top: 20px;
        }

        .reset-form md-outlined-text-field {
            margin-bottom: 20px;
            width: 100%;
        }

        .reset-ui {
            width: 450px;
        }

        @media (max-width: 768px) {
            .reset-ui {
                margin-top: .5rem;
                width: 100%; /* Ensuring the form fits smaller screens */
                padding: 0 10px;
            }
        }
    </style>
</head>

<body>

    @include('sweetalert::alert')

    <div class="reset-ui">
        <div class="reset-container">
            <div class="reset-form-container">
                <div class="reset-header">
                    <h1>Reset Password</h1>
                </div>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="reset-form">
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <md-outlined-text-field label="Email" type="email" name="email" required autofocus></md-outlined-text-field>
                        <md-filled-button class="button" type="submit">Send Password Reset Link</md-filled-button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
