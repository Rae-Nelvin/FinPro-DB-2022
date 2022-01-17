<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Dashboard | Checkout</title>

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
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/checkout-style.css') }}" rel="stylesheet">
</head>
<body>

<!-- ======= Header ======= -->
<header id="header" class="d-flex align-items-center">
            <div class="container d-flex align-items-center">

            <h1 class="logo me-auto"><a href="{{ route('/') }}">Bake n Cake</a></h1>

            <nav id="navbar" class="navbar">
                <ul>
                <li><a class="nav-link scrollto" href="{{ route('/') }}">Home</a></li>
                <li><a class="nav-link scrollto" href="#">About</a></li>
                <li><a class="nav-link scrollto" href="#">Services</a></li>
                <li><a class="nav-link scrollto " href="#">Catalog</a></li>
                <li><a class="nav-link scrollto" href="#">Contact</a></li>
                <li><a class="nav-link scrollto" href="{{ route('user.transaction') }}">Transaction</a></li>
                <li><a class="getstarted scrollto" href="{{ route('user.logout') }}">Logout</a></li>
                <li>
                    <a class="nav-link scrollto " href="{{ route('user.cart') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">
                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                </a>
                </li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>
            <!-- .navbar -->

            </div>
        </header>
        <!-- End Header -->

 

  <main id="main">
    <div class="container">
      <div class="py-5 text-center">
        <!-- <img class="d-block mx-auto mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72"> -->
        <h2>Checkout form</h2>       
      </div>
      <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Your cart</span>
            <span class="badge badge-secondary badge-pill">3</span>
          </h4>
          <ul class="list-group mb-3">
              @foreach($transaction as $transactions)
            <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div>
                <h6 class="my-0">{{ $transactions->namaMenu }}</h6>
                <small class="text-muted">{{ $transactions->jumlahBarang }}</small>
              </div>
              <span class="text-muted">Rp {{ $transactions->totalHarga2 }}</span>
            </li>
            @endforeach
            <li class="list-group-item d-flex justify-content-between">
              <span>Total (Rupiah)</span>
              <strong>Rp {{ $transactions->totalHarga }}</strong>
            </li>
          </ul>
        </div>
        <div class="col-md-8 order-md-1">
          <h4 class="mb-3">Billing address</h4>
          <form class="needs-validation" novalidate="" method="POST" action="{{ route('user.payment') }}">
            @csrf
            <input type="hidden" name="transaksiID" value="{{ $transactions->tdid }}">
            <input type="hidden" name="pembeliID" value="{{ $user->id }}">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName">First name</label>
                <input type="text" class="form-control disabled" id="firstName" placeholder="{{ $user->name }}" value="{{ $user->name }}" required="" name="name" disabled="disable">
              </div>

            <div class="mb-3">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" placeholder="{{ $user->email }}"  disabled="disable">
            </div>

            <div class="mb-3">
              <label for="address">Address <span class="text-muted">(
                Fill if you want delivery option)</span> </label>
              <input type="text" class="form-control" id="address" name="address" placeholder="" required="">
              <div class="invalid-feedback">
                Please enter your shipping address.
              </div>
            </div>
            <button class="btn btn-lg btn-block mb-5" type="submit" value="submit">Proceed to payment</button>

          </form>
        </div>
      </div>
    </div>
  </main>
  <!-- End #main -->

        <!-- ======= Footer ======= -->
        <footer id="footer">
            <div class="container">
            <h3>Bake n Cake</h3>
            <p>Et aut eum quis fuga eos sunt ipsa nihil. Labore corporis magni eligendi fuga maxime saepe commodi placeat.</p>
            <div class="social-links">
                <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            </div>
            <div class="copyright">
                &copy; Copyright <strong><span>Bake n Cake</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/green-free-one-page-bootstrap-template/ -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
            </div>
        </footer>
        <!-- End Footer -->

        <!-- Vendor JS Files -->
        <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
        <script>
            function initFreshChat() {
            window.fcWidget.init({
                token: "a149c6ea-e0b1-4fea-b5e4-82f27f58a2a1",
                host: "https://wchat.freshchat.com",
            });
            }
            function initialize(i,t){var e;i.getElementById(t)?initFreshChat():((e=i.createElement("script")).id=t,e.async=!0,e.src="https://wchat.freshchat.com/js/widget.js",e.onload=initFreshChat,i.head.appendChild(e))}function initiateCall(){initialize(document,"Freshdesk Messaging-js-sdk")}window.addEventListener?window.addEventListener("load",initiateCall,!1):window.attachEvent("load",initiateCall,!1);
        </script>

        <!-- Template Main JS File -->
        <script src="{{ asset('assets/js/main.js') }}"></script>
    
</body>
</html>