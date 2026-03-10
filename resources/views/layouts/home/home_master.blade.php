<!doctype html>
<html lang="kh">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('vendor/img/OCT-LogoG2.png') }}" type="image/x-icon">
    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/css/home-master.css') }}">
</head>

<body class="kh-content">
    <!-- Header -->
    <header>
        <div class="container-fluid top-header">
            <div class="container text-white">
                <div class="row p-0 m-0">
                    <div class="col-lg-6 p-0 m-0">
                        <div class="d-flex align-items-center gap-3 fw-bold">
                            <i class="bi bi-telephone-fill"></i>
                            <span>+855 16 222 620</span> |
                            <i class="bi bi-envelope-fill"></i>
                            <span>info@oseyteychurch.com</span>
                        </div>
                    </div>
                    <div class="col-lg-6 p-0 m-0 text-center d-none d-lg-block">
                        <div
                            class="kh-title d-flex d-md-block align-items-center justify-content-center justify-content-md-end gap-3">
                            <a href="/" class="top-item-nav text-decoration-none">ទំព័រដើម</a>
                            <a href="#" class="top-item-nav text-decoration-none">ទំនាក់ទំនង</a>
                            @auth
                                @if (auth()->user()->user_type === 'public')
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-link p-0 top-item-nav text-decoration-none border-0 bg-transparent">ចាកចេញ</button>
                                    </form>
                                @else
                                    <a href="{{ route('dashboard') }}" target="_blank"
                                        class="top-item-nav text-decoration-none">ផ្ទាំងគ្រប់គ្រង</a>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-link p-0 top-item-nav text-decoration-none border-0 bg-transparent">ចាកចេញ</button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" target="_blank"
                                    class="top-item-nav text-decoration-none">ចូលប្រើប្រាស់</a>
                            @endauth
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="container-fluid">
            <div class="container">
                <div class="row py-5">
                    <div class="col-12 pt-3">
                        <h1 class="text-center kh-header text-white">ក្រុមជំនុំព្រះជាម្ចាស់ អូសេតេ,ក្រុងព្រះសីហនុ</h1>
                    </div>
                </div>
                <nav class="navbar navbar-expand-lg navbar-bg">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item kh-nav-item">
                                    <a class="nav-link active" aria-current="page" href="/">ទំព័រដើម</a>
                                </li>
                                <li class="nav-item kh-nav-item">
                                    <a class="nav-link" href="#">ព្រះបន្ទូល</a>
                                </li>
                                <li class="nav-item kh-nav-item">
                                    <a class="nav-link" href="#">ព័ត៌មាន</a>
                                </li>
                                <li class="nav-item dropdown kh-nav-item">
                                    <a class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        ព័ន្ធកិច្ច
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">ព័ន្ធកិច្ច ក្រុមស្ត្រី</a></li>
                                        <li><a class="dropdown-item" href="#">ព័ន្ធកិច្ច ក្រុមយុវជន</a></li>
                                        <li><a class="dropdown-item" href="#">ព័ន្ធកិច្ច ក្រុមជំនុំ</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown kh-nav-item">
                                    <a class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        ព័ន្ធកិច្ចដំណឹងល្អ
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">ព្រះវិហារ សន្តិភាព</a></li>
                                        <li><a class="dropdown-item" href="#">ព្រះវិហារ ប៊ែតអ៊ែល</a></li>
                                        <li><a class="dropdown-item" href="#">ព្រះវិហារ សេចក្ដីស្រឡាញ់</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item kh-nav-item">
                                    <a class="nav-link" href="#">និមិត្ត និងចក្ខុវិស្ស័យ</a>
                                </li>
                                <li class="nav-item kh-nav-item">
                                    <a class="nav-link" href="#">អំពីក្រុមជំនុំ</a>
                                </li>
                                <li class="nav-item kh-nav-item">
                                    <a class="nav-link" href="#">ទំនាក់ទំនង</a>
                                </li>
                            </ul>
                            <form class="d-flex kh-nav-item" role="search">
                                <input class="form-control me-2" type="search" placeholder="ស្វែងរក"
                                    aria-label="Search" />
                                <button class="btn btn-outline-success" type="submit">ស្វែងរក</button>
                            </form>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        </div>

    </header>
    <!-- End Header -->

    <!-- Main Content -->
    @yield('content')
    <!-- End Main Content -->

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="d-flex justify-content-center gap-2 py-3">
                <a href="#" class="text-white kh-content footer-social-icon"><i
                        class="fa-brands fa-facebook"></i></a>
                <a href="#" class="text-white kh-content footer-social-icon"><i
                        class="fa-brands fa-youtube"></i></a>
                <a href="#" class="text-white kh-content footer-social-icon"><i
                        class="fa-brands fa-tiktok"></i></a>
                <a href="#" class="text-white kh-content footer-social-icon"><i
                        class="fa-brands fa-twitter"></i></a>
                <a href="#" class="text-white kh-content footer-social-icon"><i
                        class="fa-brands fa-whatsapp"></i></a>
            </div>
            <hr class="text-white m-0 pb-1">
            <div class="row">
                <div class="col-md-3 text-center">
                    <h5 class="kh-title text-white pt-3">ក្រុមជំនុំព្រះជាម្ចាស់ អូសេតេ,ក្រុងព្រះសីហនុ</h5>
                    <img src="{{ asset('vendor/img/OCT-LogoG2.png') }}" class="mb-3" height="137rem"
                        alt="ក្រុមជំនុំព្រះជាម្ចាស់ អូសេតេ,ក្រុងព្រះសីហនុ">
                </div>
                <div class="col-md-3">
                    <h5 class="kh-title text-white py-3 text-center">ព័ន្ធកិច្ច</h5>
                    <hr class="text-white m-0 pb-2">
                    <li class="footer-item"><a href="#"><i class="bi bi-caret-right"></i> ព័ន្ធកិច្ច
                            ក្រុមស្ត្រី</a></li>
                    <li class="footer-item"><a href="#"><i class="bi bi-caret-right"></i> ព័ន្ធកិច្ច
                            ក្រុមយុវជន</a></li>
                    <li class="footer-item"><a href="#"><i class="bi bi-caret-right"></i> ព័ន្ធកិច្ច
                            ក្រុមជំនុំ</a></li>
                </div>
                <div class="col-md-3">
                    <h5 class="kh-title text-white py-3 text-center">ព័ន្ធកិច្ចដំណឹងល្អ</h5>
                    <hr class="text-white m-0 pb-2">
                    <li class="footer-item"><a href="#"><i class="bi bi-caret-right"></i> ព្រះវិហារ
                            សន្តិភាព</a></li>
                    <li class="footer-item"><a href="#"><i class="bi bi-caret-right"></i> ព្រះវិហារ
                            ប៊ែតអ៊ែល</a></li>
                    <li class="footer-item"><a href="#"><i class="bi bi-caret-right"></i> ព្រះវិហារ
                            សេចក្ដីស្រឡាញ់</a></li>
                </div>
                <div class="col-md-3">
                    <h5 class="kh-title text-white py-3 text-center">ទំនាក់ទំនង</h5>
                    <p class="text-white kh-content m-1">
                        <i class="fa-solid fa-map-location-dot"></i>
                        អាសយដ្ឋាន៖ ក្រុមទី ១៣ ភូមិ ៣ សង្កាត់ ២ ក្រុងព្រះសីហនុ ខេត្តព្រះសីហនុ កម្ពុជា
                    </p>
                    <p class="text-white kh-content m-1">
                        <i class="fa-solid fa-phone"></i>
                        +855 16 222 620
                    </p>
                    <p class="text-white kh-content">
                        <i class="fa-solid fa-envelope"></i>
                        info@oseyteychurch.com
                    </p>
                </div>
            </div>
        </div>
        <div class="container">
            <hr class="text-white m-0 py-1">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="text-white kh-content">រក្សាសិទ្ធិគ្រប់យ៉ាង <span class="fw-bold"
                            style="font-family: 'Times New Roman', Times, serif;">&copy;</span> ២០២៥
                        ក្រុមជំនុំព្រះជាម្ចាស់ អូសេតេ,ក្រុងព្រះសីហនុ</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer -->

    <!-- Links Scripts -->
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.slim.min.js"
        integrity="sha512-sNylduh9fqpYUK5OYXWcBleGzbZInWj8yCJAU57r1dpSK9tP2ghf/SRYCMj+KsslFkCOt3TvJrX2AV/Gc3wOqA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"
        integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous">
    </script>


    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/js/all.min.js"
        integrity="sha512-6BTOlkauINO65nLhXhthZMtepgJSghyimIalb+crKRPhvhmsCdnIuGcVbR5/aQY2A+260iC1OPy1oCdB6pSSwQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
