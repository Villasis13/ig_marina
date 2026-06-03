<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
    lang="en"
    class="light-style customizer-hide"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free"
>
<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Iniciar Sesión</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('isologoIGLM.png')}}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/boxicons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}" />
    <!-- Helpers -->
    <script src="{{asset('assets/vendor/js/helpers.js')}}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('assets/js/config.js')}}"></script>

    <style>
        body {
            background: linear-gradient(135deg, #0d1b2a 0%, #1a3050 40%, #0f4c75 100%) !important;
            min-height: 100vh;
        }

        .authentication-wrapper {
            background: transparent !important;
        }

        .login-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4), 0 8px 25px rgba(0, 0, 0, 0.25);
            border: none;
            overflow: hidden;
            position: relative;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #696cff, #0f4c75, #1a3050);
        }

        .login-card .card-body {
            padding: 2.5rem 2.5rem 2rem;
        }

        .login-logo-wrapper {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .login-logo-wrapper img {
            max-width: 260px;
            width: 100%;
        }

        .login-title {
            color: #2c3e50;
            font-size: 1.1rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 1.75rem;
            letter-spacing: 0.02em;
        }

        .login-card .form-label {
            font-weight: 500;
            color: #495057;
            font-size: 0.875rem;
        }

        .login-card .form-control {
            border: 1.5px solid #dee2e6;
            border-radius: 8px;
            padding: 0.6rem 0.85rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .login-card .form-control:focus {
            border-color: #696cff;
            box-shadow: 0 0 0 3px rgba(105, 108, 255, 0.12);
        }

        .login-card .input-group .form-control {
            border-right: none;
            border-radius: 8px 0 0 8px;
        }

        .login-card .input-group-text {
            border: 1.5px solid #dee2e6;
            border-left: none;
            border-radius: 0 8px 8px 0;
            background: #f8f9fa;
            transition: border-color 0.2s;
        }

        .login-card .input-group:focus-within .input-group-text {
            border-color: #696cff;
        }

        .login-card .btn-primary {
            background: linear-gradient(135deg, #696cff, #5558e3);
            border: none;
            border-radius: 8px;
            padding: 0.65rem;
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.03em;
            transition: all 0.2s;
            box-shadow: 0 4px 15px rgba(105, 108, 255, 0.35);
        }

        .login-card .btn-primary:hover {
            background: linear-gradient(135deg, #5558e3, #4346c9);
            box-shadow: 0 6px 20px rgba(105, 108, 255, 0.5);
            transform: translateY(-1px);
        }

        .login-card .btn-primary:active {
            transform: translateY(0);
        }

        .login-footer {
            text-align: center;
            margin-top: 1.25rem;
            color: #8a9bb0;
            font-size: 0.78rem;
        }

        .login-footer span {
            display: block;
            color: #6c757d;
            font-size: 0.82rem;
        }

        .wave-bg {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            opacity: 0.06;
            pointer-events: none;
        }
    </style>
</head>

<body>
<!-- Content -->

<svg class="wave-bg" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
    <path fill="#ffffff" fill-opacity="1" d="M0,192L48,176C96,160,192,128,288,133.3C384,139,480,181,576,197.3C672,213,768,203,864,181.3C960,160,1056,128,1152,128C1248,128,1344,160,1392,176L1440,192L1440,320L1392,320L1344,320L1248,320L1152,320L1056,320L960,320L864,320L768,320L672,320L576,320L480,320L384,320L288,320L192,320L96,320L48,320L0,320Z"></path>
</svg>

<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <div class="card login-card">
                <div class="card-body">
                    <div class="login-logo-wrapper">
                        <img src="{{asset('logo_IGLM.png')}}" alt="IG La Marina">
                    </div>

                    <form id="formAuthentication" class="mb-3" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">Nombre de usuario</label>
                            <input
                                type="text"
                                class="form-control"
                                id="username"
                                name="username"
                                autofocus
                            />
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">Contraseña</label>
                            </div>
                            <div class="input-group input-group-merge">
                                <input
                                    type="password"
                                    id="password"
                                    class="form-control"
                                    name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password"
                                />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember" />
                                <label class="form-check-label" for="remember">Recordar Sesión</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" id="btn_iniciar_sesion" type="submit">Iniciar Sesión</button>
                        </div>
                    </form>

                    <div class="login-footer">
                        <span>Sistema de Gestión Comercial</span>
                        IG La Marina &copy; {{ date('Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- / Content -->
<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
<script src="{{asset('assets/vendor/libs/popper/popper.js')}}"></script>
<script src="{{asset('assets/vendor/js/bootstrap.js')}}"></script>
<script src="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
<script src="{{asset('assets/vendor/js/menu.js')}}"></script>
<script src="{{asset('js/domain.js')}}"></script>
<script src="{{asset('js/tours.js')}}"></script>
<script src="{{asset('js/login.js')}}"></script>
<!-- endbuild -->
<!-- Vendors JS -->
<!-- Main JS -->
<script src="{{asset('assets/js/main.js')}}"></script>
<!-- Page JS -->
</body>
</html>
