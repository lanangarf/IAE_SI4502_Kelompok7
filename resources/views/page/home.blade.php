@extends('layouts.app')

@section('content')
<!-- Slider Area Start -->
<section class="slider-area hero-overly"
    style="margin-top: -1px; background-image: url({{ isset($homes[0]['img_banner']) ? $homes[0]['img_banner'] : '' }}); background-repeat: no-repeat; background-position: top center;">
    <div class="slider-active">
        <!-- Single Slider -->
        <div class="single-slider slider-height d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-xl-7 col-lg-9 col-md-10 col-sm-9">
                        <div class="hero__caption">
                            @if(isset($homes[0]))
                                <h1 data-animation="fadeInLeft" data-delay="0.2s">{{ $homes[0]['judul'] }}</h1>
                                <p data-animation="fadeInLeft" data-delay="0.4s">{{ $homes[0]['deskripsi'] }}</p>
                            @else
                                <p>No posts available.</p>
                            @endif
                            <a href="" class="btn hero-btn" data-animation="fadeInLeft" data-delay="0.7s">Layanan
                                Kami</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Slider Area End -->

<!-- Services Area Start -->
<section class="services-area pt-top pb-20 mb-60">
    <div class="container border-bottom ">
        <div class="row justify-content-center ">
            <div class="col-xl-7 col-lg-8">
                <div class="section-tittle text-center mb-55">
                    @if(isset($prosess[0]))
                        <span class="element">{{ $prosess[0]['tema'] }}</span>
                        <h2>{{ $prosess[0]['sub_tema'] }}</h2>
                    @else
                        <p>No posts available.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($prosess as $proses)
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="single-cat text-center">
                        <div class="cat-icon">
                            @if (Str::contains($proses['icon'], 'proses'))
                                <img src="{{ asset('storage/' . $proses['icon']) }}" alt="">
                            @else
                                <img src="{{ asset($proses['icon']) }}" alt="">
                            @endif
                        </div>
                        <div class="cat-cap">
                            <h5><a href="/layanan">{{ $proses['judul'] }}</a></h5>
                            <p>{{ $proses['deskripsi'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Services End -->

<!-- Offer-services Start -->
<section class="offer-services pb-bottom2">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8">
                <div class="section-tittle text-center mb-55">
                    @if(isset($layanans[0]))
                        <span class="element">{{ $layanans[0]['tema'] }}</span>
                        <h2>{{ $layanans[0]['sub_tema'] }}</h2>
                    @else
                        <p>No posts available.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="row no-gutters">
            @foreach ($layanans as $index => $layanan)
                <div class="col-lg-6 col-md-6">
                    <div class="single-offers">
                        @if (Str::contains($layanan['img1'], 'layanan'))
                            <img src="{{ asset('storage/' . $layanan['img1']) }}" alt="" class=" w-100"
                                style="width: 585px; height: 598px;">
                        @else
                            <img src="{{ $layanan['img1'] }}" alt="" class=" w-100" style="width: 585px; height: 598px;">
                        @endif
                        @if($index % 2 != 0)
                            <div class="offers-caption text-center">
                                <div class="cat-icon">
                                    @if (Str::contains($layanan['img_icon'], 'layanan'))
                                        <img src="{{ asset('storage/' . $layanan['img_icon']) }}" alt="">
                                    @else
                                        <img src="{{ $layanan['img_icon'] }}" alt="">
                                    @endif
                                </div>
                                <div class="cat-cap">
                                    <h5><a href="#">{{ $layanan['judul'] }}</a></h5>
                                    <p>{{ $layanan['deskripsi'] }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="single-offers">
                        @if (Str::contains($layanan['img2'], 'layanan'))
                            <img src="{{ asset('storage/' . $layanan['img2']) }}" alt="" class=" w-100"
                                style="width: 585px; height: 598px;">
                        @else
                            <img src="{{ $layanan['img2'] }}" alt="" class=" w-100" style="width: 585px; height: 598px;">
                        @endif
                        @if($index % 2 == 0)
                            <div class="offers-caption text-center">
                                <div class="cat-icon">
                                    @if (Str::contains($layanan['img_icon'], 'layanan'))
                                        <img src="{{ asset('storage/' . $layanan['img_icon']) }}" alt="">
                                    @else
                                        <img src="{{ $layanan['img_icon'] }}" alt="">
                                    @endif
                                </div>
                                <div class="cat-cap">
                                    <h5><a href="#">{{ $layanan['judul'] }}</a></h5>
                                    <p>{{ $layanan['deskripsi'] }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Offer-services End -->

<!-- Want To work -->
<section class="container">
    <section class="wantToWork-area" data-background="{{ asset('/img/gallery/section_bg01.png') }}">
        <div class="wants-wrapper w-padding2">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-8 col-lg-9 col-md-7">
                    <div class="wantToWork-caption wantToWork-caption2">
                        @foreach($kontaks as $kontak)
                            <h2>{{ $kontak['judul'] }}</h2>
                            <p>{{ $kontak['deskripsi'] }}</p>
                        @endforeach
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-5">
                    <a href="#" class="btn wantToWork-btn">
                        <img src="{{ asset('/img/icon/call2.png') }}" alt=""> Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </section>
</section>
<!-- Want To work End -->



<!-- About Area  -->
<section class="about-area2 mt-30">
    <div class="container">
        <div class="row align-items-center">
            @foreach($data_tentang_kami as $tentang_kami)
                <div class="col-lg-6 col-md-12">
                    <!-- about-img -->
                    <div class="about-img ">

                        @if (Str::contains($tentang_kami['img'], 'tentang'))
                            <img src="{{ asset('storage/' . $tentang_kami['img']) }}" alt="">
                        @else
                            <img src="{{ asset($tentang_kami['img']) }}" alt="">
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="about-caption mb-50">
                        <!-- Section Tittle -->
                        <div class="section-tittle mb-25">
                            <h2>{{ $tentang_kami['judul'] }}</h2>
                        </div>
                        <p class="mb-20">
                            {{ $tentang_kami['deskripsi'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection