<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Armada</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        body {
            min-height: 100vh;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: #fff;
            flex-shrink: 0;
        }

        .sidebar .nav-link {
            color: #adb5bd;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background-color: #495057;
            color: #fff;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
            background: #f8f9fa;
        }

        .navbar-brand {
            font-weight: bold;
        }
    </style>
</head>

<body>

    {{-- Sidebar --}}
    <div class="sidebar d-flex flex-column p-3">
        <h4 class="text-white">🚚 Manajemen</h4>
        <hr class="bg-secondary">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ route('fleets.index') }}" class="nav-link {{ request()->is('fleets*') ? 'active' : '' }}">
                    Armada
                </a>
            </li>
            <li>
                <a href="{{ route('shipments.index') }}"
                    class="nav-link {{ request()->is('shipments*') ? 'active' : '' }}">
                    Pengiriman
                </a>
            </li>
            <li>
                <a href="{{ route('bookings.index') }}"
                    class="nav-link {{ request()->is('bookings*') ? 'active' : '' }}">
                    Pemesanan
                </a>
            </li>
            <li>
                <a href="{{ route('shipments.report') }}"
                    class="nav-link {{ request()->is('shipments/report*') ? 'active' : '' }}">
                    Laporan
                </a>
            </li>
        </ul>
        <hr class="bg-secondary">
        <a href="/" class="btn btn-outline-light btn-sm mt-auto">🏠 Dashboard</a>
    </div>

    {{-- Content --}}
    <div class="content">
        {{-- Top Navbar --}}
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
            <div class="container-fluid">
                <span class="navbar-brand">Sistem Manajemen Armada</span>
            </div>
        </nav>

        {{-- Flash message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Page Content --}}
        @yield('content')
    </div>

    {{-- Bootstrap JS Bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    {{-- jQuery (opsional kalau mau dipakai untuk interaksi tambahan) --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @stack('scripts')
</body>

</html>
