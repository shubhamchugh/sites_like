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
                        <div class="cc"><img class="img-fluid mt-2"
                                src="https://s3.us-west-1.wasabisys.com/similer/scrape/thumbnail/{{ $post->thumbnail }}">
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <h2>Sites like {{ ucfirst($post->slug) }}</h2>
                        <h3>{{ $post->seo_analyzers_relation->domain_title }}</h3>
                        <p>{{ $post->seo_analyzers_relation->domain_description }}</p>

                    </div>

                    <div class="col-12 col-md-4">
                        <a class="btn btn-meta btn-light ">
                            <img class="img-fluid" src="{{ asset('themes/manvendra/assets/images/4.png') }}">
                            {{ $post->ip ?? "" }}
                        </a>

                        <a class="btn btn-meta btn-light ">
                            <img class="img-fluid" src="{{ asset('themes/manvendra/assets/images/5.png') }}">
                            {{ $post->ip_record_relation->country_name ?? "" }}
                        </a>

                        <a class="btn btn-meta btn-light ">
                            <img class="img-fluid" src="{{ asset('themes/manvendra/assets/images/ssl.png') }}">
                            {{ (($post->Ssl_Details_relation->isValid == 1) ? 'Valid SSL' : 'InValid SSL') ?? "" }}
                        </a>

                        <a href="{{ route('post.show',['slug'=>$post->slug]) }}"
                            class="btn btn-success btn-product">Site Like {{
                            ucfirst($post->slug) }}</a>
                    </div>
                </div>
            </div>
            @endforeach



        </div>
    </div>
</section>
<!-- end of like-->
@endsection