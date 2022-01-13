<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Register</title>

      <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    
      <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

      <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/login-style.css') }}" rel="stylesheet">
</head>
<body>

    <div class="center">
        <h1>Sign Up</h1>
        <form action="{{ route('user.create') }}" method="post" autocomplete="off">
        @if (Session::get('Fail'))
            <div class="alert alert-danger">
                {{ Session::get('Fail') }}
            </div>
        @endif
        @csrf
          <div class="txt_field">
            <input type="text" name="name" value="{{ old('name') }}">
            <span class="text-danger">@error('name'){{ $message }} @enderror</span>
            <label>Full Name</label>
          </div>
          <div class="txt_field">
            <input type="text" name="email" value="{{ old('email') }}">
            <span class="text-danger">@error('email'){{ $message }} @enderror</span>
            <label>Email</label>
          </div>
          <div class="txt_field">
            <input type="password" name="password" value="{{ old('password') }}">
            <span class="text-danger">@error('password'){{ $message }} @enderror</span>
            <label>Password</label>
          </div>
          <div class="txt_field">
            <input type="password" name="cpassword" value="{{ old('cpassword') }}">
            <span class="text-danger">@error('cpassword'){{ $message }} @enderror</span>
            <label>Confirm Password</label>
          </div>
          <input type="submit" value="Submit">
          <div class="signup_link">
            Already have an account? <a href="{{ route('login') }}">Login here</a>
          </div>
        </form>
    </div>

      <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    
</body>
</html>