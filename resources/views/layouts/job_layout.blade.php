<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | Gemcon Group</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
          integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
          crossorigin="anonymous" referrerpolicy="no-referrer" rel="stylesheet" />

    <link rel="stylesheet" href="/css/job.css">
    @stack('styles')
</head>

<body>
<nav class="section-navbar navbar navbar-expand-lg">
    <div class="container-fluid navbar-ctn">
        <!-- Navbar Brand (left side) -->
        <a class="navbar-brand" href="https://gemcongroup.com/">
            <img src="{{ asset('admin_assets/images/gemcon-logo.png') }}" class="logo-img logo-dark"
                 alt="Logo" />
        </a>

        <!-- Toggle button for mobile view -->
        <button class="navbar-toggler" type="button" id="toggleButton">
            <span class="bar-icons"></span>
            <span class="bar-icons"></span>
            <span class="bar-icons"></span>
        </button>

        <!-- Navbar Items (right side) -->
        <div class="collapse navbar-collapse justify-content-end desktop-menu" id="navbarNav">
            <ul class="navbar-nav">
                <!-- First menu item -->
                <li class="nav-item">
                    <a class="nav-link active" href="https://gemcongroup.com">Home</a>
                </li>
                <!-- Second menu item with dropdown and submenu -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        About us
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="https://gemcongroup.com/about-us/founder-message">Founder
                                Message</a></li>
                        <li><a class="dropdown-item" href="https://gemcongroup.com/about-us/history">History</a>
                        </li>
                        <li><a class="dropdown-item"
                               href="https://gemcongroup.com/about-us/mission-vision/">Mission, Vision, Values</a>
                        </li>
                        <li><a class="dropdown-item" href="https://gemcongroup.com/about-us/awards/">Awards</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        Our Businesses
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <!-- Group Concerns Dropdown Submenu -->
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">Engineering</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item"
                                       href="https://gemcongroup.com/businesses/engineering/marine-engineering-ltd/">Marine
                                        Engineering Ltd</a></li>
                                <li><a class="dropdown-item"
                                       href="https://gemcongroup.com/businesses/engineering/castle-construction/">Castle
                                        Construction</a></li>
                                <li><a class="dropdown-item"
                                       href="https://gemcongroup.com/businesses/engineering/gemcon-ltd/">Gemcon
                                        Ltd</a></li>
                                <li><a class="dropdown-item"
                                       href="https://gemcongroup.com/businesses/engineering/charka-steel-ltd/">Charka
                                        Steel Ltd</a></li>
                            </ul>
                        </li>
                        <li><a class="dropdown-item" href="https://gemcongroup.com/businesses/organic-tea/">Organic
                                Tea</a></li>
                        <li><a class="dropdown-item" href="https://gemcongroup.com/businesses/retail/">Retail</a>
                        </li>
                        <li><a class="dropdown-item"
                               href="https://gemcongroup.com/businesses/e-commerce/">E-commerce</a></li>
                        <li><a class="dropdown-item" href="https://gemcongroup.com/businesses/real-estate/">Real
                                Estate</a></li>
                        <li><a class="dropdown-item" href="https://gemcongroup.com/businesses/jute/">Jute</a></li>
                        <li><a class="dropdown-item" href="https://gemcongroup.com/businesses/sea-food/">Sea
                                Food</a></li>
                        <li><a class="dropdown-item" href="https://gemcongroup.com/businesses/sweets/">Sweets</a>
                        </li>
                        <li><a class="dropdown-item" href="https://gemcongroup.com/businesses/herbal/">Herbal</a>
                        </li>
                    </ul>
                </li>

                <!-- Third menu item -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        People
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item"
                               href="https://gemcongroup.com/people/board-of-directors/">Board
                                of Directors</a></li>
                        <li><a class="dropdown-item"
                               href="https://gemcongroup.com/people/management-team/">Management</a></li>
                        <li><a class="dropdown-item" href="https://gemcongroup.com/people/talent/">Talent</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                       role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Non-Profits
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item text-wrap"
                               href="https://gemcongroup.com/non-profit-affiliates/ulab/">
                                University of Liberal Arts Bangladesh
                            </a></li>
                        <li><a class="dropdown-item"
                               href="https://gemcongroup.com/non-profit-affiliates/ksf/">Kazi Shahid
                                Foundation</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="https://hrms.gemconit.com/career/">Careers</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="https://gemcongroup.com/contact/">Contact</a>
                </li>
            </ul>
        </div>

    </div>
</nav>

@yield('content')

<footer class="footer p-2">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between">
            <a href="#" class="address">
                <span>House: 44, Road- 16 (27 Old), Dhanmondi, Dhaka-1209, Bangladesh</span>
                <span>+88 02 41020596,97,98,99,00,01,02</span>
                <span>info@gemcongroup.com</span>
            </a>
            <p class="copy">
                Copyright &copy; 2020 GEMCON GROUP. All rights reserved.
            </p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="./js/script.js"></script>

@stack('scripts')
</body>

</html>
