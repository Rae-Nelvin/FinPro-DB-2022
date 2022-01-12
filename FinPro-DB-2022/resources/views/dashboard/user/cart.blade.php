<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard | Cart</title>
    <link rel="stylesheet" href="{{ asset('bootstrap.min.css') }}">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3" style="margin-top: 45px">
                <h4>User Dashboard</h4><br>
                <table class="table table-striped table-inverse table-responsive">
                    <thead class="thead-inverse">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ Auth::guard('web')->user()->name }}</td>
                            <td>{{ Auth::guard('web')->user()->email }}</td>
                            <td>
                                <a href="{{ route('user.logout') }}">Logout</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3" style="margin-top: 45px">
                <h4>Cart List</h4><br>
                <table class="table table-striped table-inverse table-responsive">
                    <thead class="thead-inverse">
                        <tr>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $cart as $carts )
                        <tr>
                            <td>{{ $carts->namaMenu }}</td>
                            <td><img src="/assets/carts/{{ $carts->linkGambar }}" alt="{{ $carts->linkGambar }}" style="width:100%"></td>
                            <td>{{ $carts->jumlahBarang }}</td>
                            <td>Rp. {{ $carts->hargaJual }}</td>
                            <td><a href="{{ route('user.remove_cartitem',$carts->tdid) }}"><button class="btn btn-danger">Remove</button></a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                    <div class="center">
                        <h4>Total harga : {{ $carts->totalHarga }}</h4>
                        <a href="#"><button class="btn btn-success">Checkout</button></a>
                    </div>
            </div>
        </div>
    </div>
</body>
</html>