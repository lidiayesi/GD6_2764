<nav class="navbar navbar-expand navbar-dark bg-primary"> 
        <div class="container"> 
            <a class="navbar-brand" href="{{ route('home') }}">TiketWar</a> 
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('konser.*') ? 'active' : '' }}" href="{{ route('konser.index') }}">Konser</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pesanan.index') }}">Pesanan</a>
                 </li>
                 <li class="nav-item">
                    <a class="nav-link" href="{{ route('laporan.index') }}">Laporan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('promotor.index') }}">Promotor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tentang') ? 'active' : '' }}" href="{{ route('tentang') }}">Tentang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('kontak') ? 'active' : '' }}" href="{{ route('kontak') }}">Kontak</a>
                </li>
                
            </ul>
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item d-flex align-items-center me-2">
                        <span class="navbar-text">{{ auth()->user()->name }}</span>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="btn btn-sm btn-outline-secondary">Keluar</button>
                        </form>
                    </li>
                @endauth
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login Admin</a>
                    </li>
                @endguest
            </ul>
        </div> 
    </nav>