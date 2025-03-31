<!DOCTYPE html>
<html>
<head>
    <title>NomNom</title>
    @livewireStyles
    <!-- Thêm Bootstrap CSS để giao diện đẹp hơn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('css')
</head>
<body>
@include('../include/header')
@yield('content')
@include('../include/footer')
@stack('js')
</body>
</html>


