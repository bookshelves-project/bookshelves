@extends('layouts.wiki')

@section('content')
    <div>
        <div class="text-lg font-semibold">
            Current versions
        </div>
        <ul>
            <li>{{ config('app.name') }}: {{ $appVersion }}</li>
            <li>Laravel: {{ $laravelVersion }}</li>
            <li>PHP: {{ $phpVersion }}</li>
        </ul>
    </div>
    <button id="sidebarBtn" type="button"
        class="inline-flex 2xl:hidden items-center px-4 py-2 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 z-50 fixed top-5 left-5 ">
        <span class="my-auto">
            {!! getIcon('menu', 30) !!}
        </span>
    </button>
    <div id="toc"
        class="-translate-x-full 2xl:translate-x-0 relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-indigo-700 transform transition duration-100">
        <h3>Table of Contents</h3>
        <nav id="navbar" class="navbar fixed-top navbar-expand navbar-dark">
            <div class="navbar-collapse">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#home">home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#bio">bio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#work">work</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">contact</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <main id="content">
        <section id="home" class="hero-bg h-100">
            <div class="container h-100">
                <div class="row h-100 justify-content-center">
                    <div class="col-lg-8 my-auto text-center">
                        <h1><i class="fas fa-home"></i></h1>
                    </div>
                </div>
            </div>
        </section>
        <section id="bio" class="hero-bg h-100">
            <div class="container h-100">
                <div class="row h-100 justify-content-center">
                    <div class="col-lg-8 my-auto text-center">
                        <h1><i class="fas fa-address-card"></i></h1>
                    </div>
                </div>
            </div>
        </section>
        <section id="work" class="hero-bg h-100">
            <div class="container h-100">
                <div class="row h-100 justify-content-center">
                    <div class="col-lg-8 my-auto text-center">
                        <h1><i class="fas fa-briefcase"></i></h1>
                    </div>
                </div>
            </div>
        </section>
        <section id="contact" class="hero-bg h-100">
            <div class="container h-100">
                <div class="row h-100 justify-content-center">
                    <div class="col-lg-8 my-auto text-center">
                        <h1><i class="fas fa-phone-square"></i></h1>
                    </div>
                </div>
            </div>
        </section>
        {!! $content !!}
    </main>
@endsection
