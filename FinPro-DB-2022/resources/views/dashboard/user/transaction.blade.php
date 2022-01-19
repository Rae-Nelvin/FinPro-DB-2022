<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard | Transaction</title>
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

      <h1 class="logo me-auto"><a href="{{ route('user.home') }}">Bake n Cake</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar">
            <ul>
            <li><a class="nav-link scrollto" href="{{ route('user.home') }}">Home</a></li>
            <li><a class="nav-link scrollto" href="#">About</a></li>
            <li><a class="nav-link scrollto" href="#">Services</a></li>
            <li><a class="nav-link scrollto " href="#">Catalog</a></li>
            <li><a class="nav-link scrollto" href="#">Contact</a></li>
            <li><a class="nav-link scrollto" href="{{ route('user.transaction') }}">Transaction</a></li>
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
  </header><!-- End Header -->

 

  <main id="main">
    <div class="container">
        <h2>Unpaid Transactions</h2>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
              <div class="col-md-12 order-md-1 mb-4">
                <ul class="list-group mb-3">
                  <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                      @foreach( $unpaidTransaction as $unpaidTransactions )
                      <h4 class="my-1">{{ $unpaidTransactions->id }}</h4>
                        @foreach($unpaidTransaction2 as $unpaidTransaction2s)
                        <h6 class="my-1">{{ $unpaidTransaction2s->namaMenu }}</h6>
                        @endforeach
                    </div>
                    <span class="text-muted">Rp {{ $unpaidTransactions->totalHarga }}</span>
                    @endforeach
                  </li>
                </ul>
              </div>
          </div>
        </div>
        <h2>Ongoing Transactions</h2>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
              <div class="col-md-12 order-md-1 mb-4">
                <ul class="list-group mb-3">
                  <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                    @foreach($ongoingTransaction as $ongoingTransactions)
                      <h4 class="my-1">{{ $ongoingTransactions->id }}</h4>
                        @foreach($ongoingTransaction2 as $ongoingTransaction2s)
                        <h6 class="my-1">{{ $ongoingTransaction2s->namaMenu }}</h6>
                        @endforeach
                    </div>
                    <span class="text-muted">Rp {{ $ongoingTransactions->totalHarga }}</span>
                    @endforeach
                  </li>
                </ul>
              </div>
          </div>
        </div>
        <h2>History Transactions</h2>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
              <div class="col-md-12 order-md-1 mb-4">
                <ul class="list-group mb-3">
                  <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                    @foreach($historyTransaction as $historyTransactions)
                      <h4 class="my-1">{{ $historyTransactions->id }}</h4>
                        @foreach($historyTransaction2 as $historyTransaction2s)
                        <h6 class="my-1">{{ $historyTransaction2s->namaMenu }}</h6>
                        @endforeach
                    </div>
                    <span class="text-muted">Rp {{ $historyTransactions->totalHarga }}</span>
                    @endforeach
                  </li>
                </ul>
              </div>
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
      <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
        <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
        <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
        <script src="assets/vendor/php-email-form/validate.js"></script>

        <!-- Template Main JS File -->
        <script src="assets/js/main.js"></script>

</body>
</html>