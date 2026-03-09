{{-- Email verification notice: shown when user is logged in but email not verified --}}
<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Verify Email | RODTHBAL KCM CMS</title>
    <link rel="icon" href="{{ asset('vendor/img/OCT-LogoG2.png') }}" type="image/x-icon">
    <meta name="supported-color-schemes" content="light dark" />
    <link rel="preload" href="{{ asset('vendor/css/adminlte.css') }}" as="style" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
      media="print"
      onload="this.media='all'"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="{{ asset('vendor/css/adminlte.css') }}" />
    <style>
      .login-box { width: 460px; }
      @media (max-width: 576px) { .login-box { width: 92%; } }
    </style>
  </head>
  <body class="login-page bg-body-secondary">
    <div class="login-box">
      <div class="card card-outline card-primary">
        <div class="card-header">
          <a href="{{ url('/') }}" class="link-dark text-center link-offset-2 link-opacity-100 link-opacity-50-hover">
            <h1 class="mb-0"><b>RODTHBAL</b> KCM CMS</h1>
          </a>
        </div>
        <div class="card-body login-card-body">
          <p class="login-box-msg"><i class="bi bi-envelope-check me-2"></i>Verify your email address</p>

          <p class="text-secondary mb-3">
            Thanks for signing up. Before you can access the dashboard, please verify your email address by clicking the link we sent to <strong>{{ auth()->user()->email ?? '' }}</strong>.
          </p>
          <p class="text-secondary small mb-0">
            If you didn't receive the email, click the button below and we'll send you another.
          </p>

          @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success mt-3 py-2" role="alert">
              A new verification link has been sent to your email address.
            </div>
          @endif

          <div class="mt-4 d-flex flex-column gap-2">
            <form method="POST" action="{{ route('verification.send') }}" class="d-grid">
              @csrf
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-send me-2"></i>Resend verification email
              </button>
            </form>
            <form method="POST" action="{{ route('logout') }}" class="d-grid">
              @csrf
              <button type="submit" class="btn btn-outline-secondary">Log out</button>
            </form>
          </div>

          <p class="mt-3 mb-0 small text-muted">
            After verifying your email, you can access the dashboard.
          </p>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  </body>
</html>
