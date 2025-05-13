<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to right, #74ebd5, #ACB6E5);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .card {
      border-radius: 1rem;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }

    .form-control:focus {
      box-shadow: none;
      border-color: #007BFF;
    }

    .btn-google {
      background-color: #dd4b39;
      color: white;
    }

    .btn-google:hover {
      background-color: #c23321;
      color: white;
    }

    .form-check-label {
      cursor: pointer;
    }

    .input-group-text {
      cursor: pointer;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="row justify-content-center">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="col-md-5">
      <div class="card p-4">
        <h3 class="text-center mb-4">Login to Your Account</h3>
        <form>
          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email">
          </div>
          <div class="mb-3 position-relative">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
              <input type="password" class="form-control" id="password" placeholder="Enter password">
              <span class="input-group-text" id="togglePassword">
                <i class="bi bi-eye" id="toggleIcon"></i>
              </span>
            </div>
          </div>
          {{-- <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="keepLoggedIn">
              Keep me logged in
            </label>
          </div> --}}
          <div class="d-grid mb-3">
            <a type="submit" class="btn btn-warning">Register</a>
          </div>
          <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary">Login</button>
          </div>
          <div class="d-grid">
            <a href="{{ route('auth.google') }}" type="button" class="btn btn-google">
              <i class="bi bi-google"></i> Login with Google
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  const togglePassword = document.getElementById('togglePassword');
  const passwordInput = document.getElementById('password');
  const toggleIcon = document.getElementById('toggleIcon');

  togglePassword.addEventListener('click', function () {
    const isPassword = passwordInput.getAttribute('type') === 'password';
    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
    toggleIcon.classList.toggle('bi-eye');
    toggleIcon.classList.toggle('bi-eye-slash');
  });
</script>

</body>
</html>
