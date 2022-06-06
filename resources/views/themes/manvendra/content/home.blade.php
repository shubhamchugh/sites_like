@extends('themes.manvendra.layouts.home')


@section('content')
<!-- like-->
<section>
    <div class="like">
        <div class="container">


            @foreach ($posts as $post)
            <div class="beener">
                <div class="row">
                    <div class="col-12 col-md-3">
                        <div class="cc"><img class="img-fluid mt-2" src="assets/images/img1.png"></div>
                    </div>
                    <div class="col-12 col-md-5">
                        <h2>Sites like {{ $post->slug }}</h2>
                        <h3>{{ $post->seo_analyzers_relation->domain_title }}</h3>
                        <p>{{ $post->seo_analyzers_relation->domain_description }}</p>

                    </div>

                    <div class="col-12 col-md-4">
                        <div class="dd"><img class="img-fluid" src="assets/images/img2.png"></div>
                        <button class="but"><img class="img-fluid"
                                src="{{ asset('themes/manvendra/assets/images/4.png') }}">
                            {{ $post->ip ?? "" }}</button>
                        <button class="but"><img class="img-fluid"
                                src="{{ asset('themes/manvendra/assets/images/5.png') }}">&nbsp;{{
                            $post->ip_record_relation->country_name ?? ""}}</button>
                        <button class="but"><img class="img-fluid"
                                src="{{ asset('themes/manvendra/assets/images/ssl.png') }}">&nbsp;{{
                            (($post->Ssl_Details_relation->isValid == 1) ? 'Valid SSL' : 'InValid SSL') ??
                            ""}}</button>
                        <button class="but1"> VIWE PRODUCT</button>
                    </div>
                </div>
            </div>
            @endforeach



        </div>
    </div>
</section>
<!-- end of like-->
@endsection