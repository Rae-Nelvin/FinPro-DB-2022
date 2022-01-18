<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Staff Upload</title>
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
                            <a href="{{ route('admin.transaction') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Transactions</a>
                            <a href="{{ route('admin.staff') }}" class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium" aria-current="page">Staff</a>
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

    <div class="container mt-8 mx-auto text-white mb-12">
        @if(Session::get('Fail'))
            <div class="bg-red-600 text-red-100">
                {{ Session::get('Fail') }}
            </div>
        @endif
        <div class="flex justify-center my-16">
            <h2 class="font-medium text-3xl">Upload New Staff</h2>
        </div>
        <div class="flex justify-center my-8">
            <form action="{{ route('admin.upload_staff') }}" class="w-1/2 bg-gray-800 rounded-md p-8 space-y-8 text-md" method="post" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4 text-lg">
                    <label for="Staff name">Staff's Name</label><br>
                    <input type="text" name="name" placeholder="Input New Staff's Name Here" class="w-full h-12 p-4 rounded-md text-black" value="{{ old('name') }}">
                    <span class="text-red-600">@error('name'){{ $message }} @enderror</span>
                </div>
                <div class="space-y-4 text-lg">
                    <label for="Picture">Staff's Picture</label><br>
                    <input type="file" name="picture" class="custom-file-input" id="inputGroupFile02" onchange="loadFile(event)"><br>
                    <img id="output" class="w-3/4 p-2"/><br>
                    <span class="text-red-600">@error('picture'){{ $message }} @enderror</span>
                </div>
                <div class="space-y-4 text-lg">
                    <label for="Staff Email">Staff's Email</label><br>
                    <input type="text" name="email" placeholder="Input New Staff's Email Here" class="w-full h-12 p-4 rounded-md text-black" value="{{ old('email') }}">
                    <span class="text-red-600">@error('email'){{ $message }} @enderror</span>
                </div>
                <div class="space-y-4 text-lg">
                    <label for="Staff Password">Staff's Password</label><br>
                    <input type="password" name="password" placeholder="Input New Staff's Password Here" class="w-full h-12 p-4 rounded-md text-black" value="{{ old('password') }}">
                    <span class="text-red-600">@error('password'){{ $message }} @enderror</span>
                </div>
                <div class="space-y-4 text-lg">
                    <label for="Staff Confirm Password">Staff's Confirm Password</label><br>
                    <input type="password" name="password_confirmation" placeholder="Input New Staff's Confirm Password Here" class="w-full h-12 p-4 rounded-md text-black" value="{{ old('password') }}">
                    <span class="text-red-600">@error('password'){{ $message }} @enderror</span>
                </div>
                <div class="space-y-6 text-lg">
                    <label for="Staff Gender">Staff's Gender</label><br>
                    <input type="radio" name="gender" value="F">
                    <label for="F">Female</label><br>
                    <input type="radio" name="gender" value="M">
                    <label for="M">Male</label><br>
                    <span class="text-red-600">@error('gender'){{ $message }} @enderror</span>
                </div>
                <div class="space-y-4 text-lg">
                    <label for="Staff Phone Number">Staff's Phone Number</label><br>
                    <input type="tel" name="pnumber" placeholder="Input New Staff's Phone Number Here" class="w-full h-12 p-4 rounded-md text-black" value="{{ old('pnumber') }}">
                    <span class="text-red-600">@error('pnumber'){{ $message }} @enderror</span>
                </div>
                <div class="space-y-4 text-lg">
                    <label for="Staff Job Desc">Staff's Job Desc</label><br>
                    <select name="jobDesc" class="w-full h-12 px-2 rounded-md text-black" value="{{ old('jobDesc') }}">
                        <option value="Chef" selected>Chef</option>
                        <option value="Courrier">Courrier</option>
                        <option value="Cashier">Cashier</option>
                    <span class="text-red-600">@error('jobDesc'){{ $message }} @enderror</span>
                    </select>
                </div>
                <div class="space-y-4 text-lg justify-center flex">
                    <button class="bg-gray-700 text-2xl mx-auto w-auto py-2 px-4 rounded-md mb-4 hover:bg-green-400 transition-all hover:scale-110 transform transition-all cursor-pointer" value="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        var loadFile =  function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
    <script>
        $('#inputGroupFile02').on('change',function(){
        var fileName = $(this).val();
        $(this).next('.custom-file-label').html(fileName);
        })
    </script>

</body>
</html>