@extends('shop.layouts.layout')

@section('content')

<!-- Page Preloder -->
<div id="preloder">
    <div class="loader"></div>
</div>

<section class="breadcrumb-section set-bg" data-setbg="{{ asset('index/img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Contact Us</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('shop.index') }}">Home</a>
                        <span>Contacts</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="contact spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                <div class="contact__widget">
                    <span class="icon_phone"></span>
                    <h4>Phone</h4>
                    <p>+63 {{ $settings['phone'] }}</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                <div class="contact__widget">
                    <span class="icon_pin_alt"></span>
                    <h4>Address</h4>
                    <p>{{ $settings['address'] }}</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                <div class="contact__widget">
                    <span class="icon_clock_alt"></span>
                    <h4>Open time</h4>
                    <p>{{ $openingTime }} to {{ $closingTime }}</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                <div class="contact__widget">
                    <span class="fa fa-facebook"></span>
                    <h4>Facebook Page</h4>
                    <a href="{{ $settings['fb_link'] }}">
                        <p>{{ $settings['fb_page'] }}</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="map">
    @if(isset($settings['map_url']))
    <div class="map-iframe">
        <iframe src="{{ $settings['map_url'] }} ?? ''" width="600" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    @else
    <p>No map available. Please enter the map URL in the settings.</p>
    @endif
    <div class="map-inside">
        <i class="icon_pin"></i>
        <div class="inside-widget">
            <h4>{{ $settings['fb_page'] }}</h4>
            <ul>
                <li>Phone: +63 {{ $settings['phone'] }}</li>
                <li>Add: {{ $settings['address'] }}</li>
            </ul>
        </div>
    </div>
</div>
@endsection