<html>
<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link href="/css/style.css" rel="stylesheet">
    <title> @yield('title')</title>
    
</head>
<body>
<div id="container">
    <header>
        <img src="/images/logo.png" id="logo">
        <div id="giohang">Giỏ hàng có 1 sản phẩm</div>
        <div id="userinfo">
            @if (Auth::check())           
                Chào {{Auth::user()->ho}} {{Auth::user()->ten}}! 
                <a href="/thoat">Thoát</a>
            @else
                Chào bạn ! 
                <a href="/dangnhap">Đăng nhập</a>
            @endif
        </div>
        
    </header>
    <nav>
        <ul>
            <li> <a href="/"> Trang chủ </a></li>     
            @foreach ($loaisp as $loai )
            <li> 
            <a href="/loai/{{$loai->id_loai}}" > {{$loai->ten_loai}} </a>
            </li>
            @endforeach
            <li> <a href="/lienhe"> Liên hệ </a></li>
            <li> <a href="/hiengiohang"> Giỏ hàng </a></li>
        </ul>
    </nav>
    <main>
        @yield('noidungchinh')
    </main>
    <footer>
        Dự án Tech chain ! Phát triển bởi sinh viên ...
    </footer>
</div> 
</body>
</html>