<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Transaction</title>
    <link rel="stylesheet" href="{{ asset('tailwind.css') }}">
    <link rel="stylesheet" href="{{ asset('tailwind-2.css') }}">
    <link rel="stylesheet" href="{{ asset('btn-css.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="bg-gray-900">

    <nav class="bg-gray-800">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex-shrink-0 flex items-center">
                        <img class="block lg:hidden h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg" alt="Workflow">
                        <img class="hidden lg:block h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-logo-indigo-500-mark-white-text.svg" alt="Workflow">
                    </div>
                    <div class="hidden sm:block sm:ml-6">
                        <div class="flex space-x-4">
                            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                            <a href="{{ route('admin.home') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                            <a href="{{ route('admin.menu') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Menus</a>
                            <a href="{{ route('admin.transaction') }}" class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium" aria-current="page">Transactions</a>
                            <a href="{{ route('admin.staff') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Staff</a>
                        </div>
                    </div>
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                    <!-- Profile dropdown -->
                    <div class="ml-3 relative">
                        <div>
                            <button type="button" class="bg-gray-800 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <span class="sr-only">Open user menu</span>
                            <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                            </button>
                        </div>
                    </div>
                    <a href="{{ route('admin.logout') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium ml-4">Logout</a>
                </div>
            </div>
        </div>
    </nav>
    
    <div class="container mx-auto mt-12 pl-14">
        <div class="ml-12 mt-4 mb-14">
            <h1 class="text-white text-4xl font-medium">On Going Transaction Lists</h1>
        </div>
        <table class="table-auto text-white border border-black border-collapse mt-8">
            <thead class="bg-gray-800">
                <tr class="row text-xl">
                    <th class="py-4 px-2">Transaction ID</th>
                    <th class="px-8">Transaction Details</th>
                    <th class="px-16">Pembeli</th>
                    <th class="px-16">Cashier Staff</th>
                    <th class="px-16">Chef Staff</th>
                    <th class="px-16">Courrier Staff</th>
                    <th class="px-16">Total Harga</th>
                    <th class="px-16">Status</th>
                    <th class="px-16">Last Update</th>
                </tr>
            </thead>
            <tbody class="bg-gray-600 text-center">
                @foreach ($transactiontoday as $transactiontodays)
                <tr class="row border border-black font-medium text-xl">
                    <td class="py-4 px-2">TR {{ $transactiontodays->tid }}</td>
                    <td>{{ $transactiontodays->namaMenu }} | {{$transactiontodays->jumlahBarang }} Qty
                    </td>
                    <td>{{ $transactiontodays->pembeliNama }}</td>
                    <td>{{ $transactiontodays->cashierStaffID }}</td>
                    <td>{{ $transactiontodays->chefStaffID }}</td>
                    <td></td>
                    <td>Rp {{ $transactiontodays->totalHarga }}</td>
                    <td>{{ $transactiontodays->status }}</td>
                    <td>{{ $transactiontodays->updated_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="container mx-auto mt-12 pl-14">
        <div class="ml-12 mt-4 mb-14">
            <h1 class="text-white text-4xl font-medium">Today Transaction History Lists</h1>
        </div>
        <table class="table-auto text-white border border-black border-collapse mt-8">
            <thead class="bg-gray-800">
                <tr class="row text-xl">
                    <th class="py-4 px-2">Transaction ID</th>
                    <th class="px-8">Transaction Details</th>
                    <th class="px-16">Pembeli</th>
                    <th class="px-16">Cashier Staff</th>
                    <th class="px-16">Chef Staff</th>
                    <th class="px-16">Courrier Staff</th>
                    <th class="px-16">Total Harga</th>
                    <th class="px-16">Status</th>
                    <th class="px-16">Last Update</th>
                </tr>
            </thead>
            <tbody class="bg-gray-600 text-center">
                @foreach ($transactionThisMonth as $transactionThisMonths)
                <tr class="row border border-black font-medium text-xl">
                    <td class="py-4 px-2">TR {{ $transactionThisMonths->tid }}</td>
                    <td>{{ $transactionThisMonths->namaMenu }} | {{$transactionThisMonths->jumlahBarang }} Qty
                    </td>
                    <td>{{ $transactionThisMonths->pembeliNama }}</td>
                    <td>{{ $transactionThisMonths->cashierStaffID }}</td>
                    <td>{{ $transactionThisMonths->chefStaffID }}</td>
                    <td></td>
                    <td>Rp {{ $transactionThisMonths->totalHarga }}</td>
                    <td>{{ $transactionThisMonths->status }}</td>
                    <td>{{ $transactionThisMonths->updated_at }}</td>
                </tr>
                    @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>