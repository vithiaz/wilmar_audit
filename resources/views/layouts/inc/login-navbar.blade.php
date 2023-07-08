<nav class="navbar">
    <div class="container">
        <div class="welcome-container">
            <span class="msg">Wilmar</span>
            <span class="username">Audit Dashboard</span>
        </div>
        <ul class="nav-menu">
            @auth
                <li class="sport"><a href="{{ route('audit') }}">Dashboard</a></li>
            @endauth
            {{-- <li class="sport"><a href="{{ route('homepage') }}">MarketPlace</a></li>
            <li class="env"><a href="{{ route('product-page', [0]) }}">Produk</a></li>
            <li class="history"><a href="{{ route('umkm-page') }}">UMKM</a></li> --}}
        </ul>
        <div class="logout">
            {{-- Logout Confirmation Modal in admin-sidebar.blade --}}
            {{-- <button type="button" class="logout-button" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</button> --}}
        </div>
    </div>
</nav>

@push('script')
    <script>

    var checkWidth = () => {
            if($(window).width() <= 767) {
                $(".admin-navbar .logout").after($(".admin-navbar .nav-menu"));
                }
            else {
                $(".admin-navbar .logout").before($(".admin-navbar .nav-menu"));
            }
    }
    checkWidth();

    // Resize Event
    $(window).resize(function () {
        checkWidth();
    });

    </script>
@endpush