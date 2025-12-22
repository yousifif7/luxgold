<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Luxgold')</title>
    <link rel="icon" href="{{ asset('assets/images/luxgold_favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    @stack('styles')
    <style>
      body { background: #f9fafc; font-family: Inter, system-ui, -apple-system, 'Segoe UI', Roboto; }

      /* Auth card styles copied from the static theme to match screenshots */
      .login-card-longkeywordclass,
      .register-card-longkeywordclass {
        background: #fff;
        border-radius: 16px;
        padding: 40px 35px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        width: 100%;
        max-width: 520px;
      }

      .login-title-longkeywordclass,
      .register-title-longkeywordclass {
        font-size: 1.8rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 25px;
        color: #2a2d34;
      }

      .login-form-label-longkeywordclass,
      .register-form-label-longkeywordclass {
        font-weight: 600;
        margin-bottom: 6px;
        color: #2a2d34;
      }

      .login-form-control-longkeywordclass,
      .register-form-control-longkeywordclass {
        border-radius: 10px;
        padding: 12px 14px;
        font-size: 0.95rem;
        border: 1px solid #ddd;
      }

      .login-form-control-longkeywordclass:focus,
      .register-form-control-longkeywordclass:focus {
        border-color: #337d7c;
        box-shadow: 0 0 0 0.2rem rgba(51,125,124,0.15);
      }

      .login-forgot-password-longkeywordclass {
        display: block;
        text-align: right;
        margin-top: 8px;
        font-size: 0.9rem;
        color: #337d7c;
        text-decoration: none;
      }

      .login-forgot-password-longkeywordclass:hover { text-decoration: underline; }

      .login-btn-longkeywordclass,
      .register-btn-longkeywordclass {
        background: #337d7c;
        border: none;
        padding: 12px;
        width: 100%;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        color: #fff;
        transition: background 0.3s;
        margin-top: 20px;
      }

      .login-btn-longkeywordclass:hover,
      .register-btn-longkeywordclass:hover { background: #285e5d; }

      .login-bottom-text-longkeywordclass,
      .register-bottom-text-longkeywordclass { margin-top: 20px; text-align: center; font-size: 0.95rem; color: #444; }
      .login-bottom-text-longkeywordclass a,
      .register-bottom-text-longkeywordclass a { color: #337d7c; font-weight: 600; text-decoration: none; }
      .login-bottom-text-longkeywordclass a:hover,
      .register-bottom-text-longkeywordclass a:hover { text-decoration: underline; }

      /* small responsive tweak */
      @media (max-width: 576px) {
        .login-card-longkeywordclass, .register-card-longkeywordclass { padding: 28px 20px; }
      }
    </style>
  </head>
  <body>
    @yield('content')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
  </body>
</html>
