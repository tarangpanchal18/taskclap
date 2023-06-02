<header class="header header-three">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg header-nav">
            <div class="navbar-header">
                <a id="mobile_btn" href="javascript:void(0);">
                    <span class="bar-icon bar-icon-three">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </a>
                <a href="index.html" class="navbar-brand logo">
                    <img src="assets/img/logo-02.svg" class="img-fluid" alt="Logo">
                </a>
                <a href="index.html" class="navbar-brand logo-small">
                    <img src="assets/img/logo-icon.png" class="img-fluid" alt="Logo">
                </a>
            </div>
            <div class="main-menu-wrapper">
                <div class="menu-header">
                    <a href="index.html" class="menu-logo">
                        <img src="assets/img/logo-02.svg" class="img-fluid" alt="Logo">
                    </a>
                    <a id="menu_close" class="menu-close" href="javascript:void(0);"> <i class="fas fa-times"></i></a>
                </div>
                <ul class="main-nav">
                    <li><a href="{{ route('homepage') }}">Home</a></li>
                    <li><a href="{{ route('homepage') }}">Ac/Appliances Service</a></li>
                    <li><a href="{{ route('homepage') }}">Salon For Men</a></li>
                    <li><a href="{{ route('homepage') }}">Salon For Women</a></li>
                    <li><a href="{{ route('homepage') }}">Home Painting</a></li>
                    <li><a href="{{ route('homepage') }}">Cleaning & Pesting</a></li>
                    <li class="login-link">
                        <a href="choose-signup.html">Register As Provider</a>
                    </li>
                    <li class="login-link">
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    </li>
                </ul>
            </div>
            <ul class="nav header-navbar-rht">
                <li class="nav-item">
                    <a class="nav-link header-login" href="choose-signup.html"><i class="feather-calendar me-2"></i>Register As Provider</a>
                </li>
                <li class="nav-item">
                    <div class="cta-btn">
                        <a class="btn" href="provider-signup.html"><i class="feather-users me-2"></i>REGISTER /</a>
                        <a class="btn ms-1" href="{{ route('login') }}">LOGIN</a>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</header>