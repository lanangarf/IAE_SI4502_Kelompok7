<footer>
    <!-- Footer Start-->
    <div class="footer-area footer-padding">
        <div class="container">
            <div class="row d-flex justify-content-between">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                    <div class="single-footer-caption mb-5  0">
                        <div class="single-footer-caption mb-30">
                            <!-- logo -->
                            <div class="footer-logo mb-35">
                                <a href="#"><img src="{{ asset('/gambar/logo laundry.png')}}" alt=""></a>
                            </div>
                            <div class="footer-tittle">
                                <div class="footer-pera">
                                    <p>Kami diformulasikan khusus untuk memberikan kebersihan maksimal pada pakaian Anda
                                        dengan kelembutan ekstra.
                                    </p>
                                </div>
                            </div>
                            <!-- social -->
                            <div class="footer-social">
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-pinterest-p"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                    <div class="single-footer-caption mb-50">
                        <div class="footer-tittle">
                            <h4>Delivery</h4>
                            <ul>
                                @forelse ($uniques as $unique)
                                    <li><a href="#">- {{ $unique }}</a></li>
                                @empty
                                    <p>No services available.</p>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                    <div class="single-footer-caption mb-50">
                        <div class="footer-tittle">
                            <h4>Hubungi Kami</h4>
                            <ul>
                                @forelse ($kontaks as $kontak)
                                    <li class="number"><a href="#">{{ $kontak['no_hp'] }}</a></li>
                                    <!-- <li><a href="#">laundry@567.com</a></li> -->
                                    <li><a href="#">{{ $kontak['alamat'] }}</a></li>
                                @empty
                                    <p>No services available.</p>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer-bottom area -->
    <div class="footer-bottom-area section-bg2" data-background="{{ asset('/img/gallery/footer-bg.png') }}">
        <div class="container">
            <div class="footer-border">
                <div class="row d-flex align-items-center">
                    <div class="col-xl-12 "></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End-->
</footer>
<!-- Scroll Up -->
<div id="back-top">
    <a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
</div>


<!--akhir FOOTER-->
<!-- Jquery, Popper, Bootstrap -->
<script src="{{ asset('/js/vendor/modernizr-3.5.0.min.js') }}"></script>
<script src="{{ asset('/js/vendor/jquery-1.12.4.min.js') }}"></script>
<script src="{{ asset('/js/popper.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap.min.js') }}"></script>

<!-- Jquery Mobile Menu -->
<script src="{{ asset('/js/jquery.slicknav.min.js') }}"></script>

<!-- Jquery Slick, Owl-Carousel Plugins -->
<script src="{{ asset('/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('/js/slick.min.js') }}"></script>
<!-- One Page, Animated-HeadLin -->
<script src="{{ asset('/js/wow.min.js') }}"></script>
<script src="{{ asset('/js/animated.headline.js') }}"></script>
<script src="{{ asset('/js/jquery.magnific-popup.js') }}"></script>

<!-- Date Picker -->
<script src="{{ asset('/js/gijgo.min.js') }}"></script>
<!-- Nice-select, sticky -->
<script src="{{ asset('/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('/js/jquery.sticky.js') }}"></script>
<!-- Progress -->
<script src="{{ asset('/js/jquery.barfiller.js') }}"></script>

<!-- counter, waypoint, Hover Direction -->
<script src="{{ asset('/js/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('/js/waypoints.min.js') }}"></script>
<script src="{{ asset('/js/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('/js/hover-direction-snake.min.js') }}"></script>

<!-- contact js -->
<script src="{{ asset('/js/contact.js') }}"></script>
<script src="{{ asset('/js/jquery.form.js') }}"></script>
<script src="{{ asset('/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/js/mail-script.js') }}"></script>
<script src="{{ asset('/js/jquery.ajaxchimp.min.js') }}"></script>

<!-- Jquery Plugins, main Jquery -->
<script src="{{ asset('/js/plugins.js') }}"></script>
<script src="{{ asset('/js/main.js') }}"></script>