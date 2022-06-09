@extends('themes.manvendra.layouts.post')


@section('content')
<!-- like-->
<section>
    <div class="like">
        <div class="container">
            <div class="beener">
                <div class="row">
                    <div class=" col-lg-9 col-md-6 col-12">
                        <h3>{{ $post->seo_analyzers_relation->domain_title ?? "" }}</h3>
                        <p>{{ $post->seo_analyzers_relation->domain_description ?? "" }}</p>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="cc"><img class="img-fluid mt-2"
                                src="https://s3.us-west-1.wasabisys.com/{{ config('filesystems.disks.wasabi.bucket') }}/scrape/thumbnail/{{ $post->thumbnail }}">
                        </div>
                    </div>

                    <!-- <div class="col-12 col-md-4">
                        <div class="dd"><img class="img-fluid" src="assets/images/img2.png"></div>
                        <button class="but"><img class="img-fluid"
                                src="assets/images/4.png">&nbsp;172.67.198.78</button>
                        <button class="but"><img class="img-fluid" src="assets/images/5.png">&nbsp;United
                            States</button>
                        <button class="but"><img class="img-fluid" src="assets/images/6.png">&nbsp;United
                            States</button>
                        <button class="but1"> VIWE PRODUCT</button>
                    </div> -->

                </div>
                <div class="bg-blog-s">
                    <div class="row">
                        <div class=" col-lg-4 col-md-6 col-12">
                            <div class="state-sec">
                                <p class="heading-blog">Stats</p>
                                <p class="p-alexa"><span><i class="fa fa-check blog-bgstate"
                                            aria-hidden="true"></i></span>&nbsp; Alexa Rank:&nbsp;<span
                                        class="span-alexa">449647</span> </p>
                                <hr>
                                <p class="p-alexa"><span><i class="fa fa-check blog-bgstate"
                                            aria-hidden="true"></i></span>&nbsp; Popular in Country:&nbsp;<span
                                        class="span-alexa"> N/A</span> </p>
                                <hr>
                                <p class="p-alexa"><span><i class="fa fa-check blog-bgstate"
                                            aria-hidden="true"></i></span>&nbsp; Country Alexa Rank: &nbsp;<span
                                        class="span-alexa">N/A</span> </p>
                                <hr>
                            </div>

                        </div>
                        <div class=" col-lg-4 col-md-6 col-12">
                            <div class="state-sec">
                                <p class="heading-blog" style="visibility: hidden;">Stats</p>
                                <p class="p-alexa"><span><i class="fa fa-check blog-bgstate"
                                            aria-hidden="true"></i></span>&nbsp;language: &nbsp;<span
                                        class="span-alexa">en</span> </p>
                                <hr>
                                <p class="p-alexa"><span><i class="fa fa-check blog-bgstate"
                                            aria-hidden="true"></i></span>&nbsp; Response Time: &nbsp;<span
                                        class="span-alexa">Response Time</span> </p>
                                <hr>
                                <p class="p-alexa"><span><i class="fa fa-check blog-bgstate"
                                            aria-hidden="true"></i></span>&nbsp; SSL: &nbsp;<span
                                        class="span-alexa">Enable</span> </p>
                                <hr>
                                <p class="p-alexa"><span><i class="fa fa-check blog-bgstate"
                                            aria-hidden="true"></i></span>&nbsp; Status: &nbsp;<span
                                        class="span-alexa">up</span> </p>
                                <hr>
                            </div>
                        </div>
                        <div class=" col-lg-4 col-md-6 col-12">
                            <div class="state-sec">
                                <p class="heading-blog">Code To Txt Ratio</p>
                                <p class="p-alexa"><span><i class="fa fa-check blog-bgstate"
                                            aria-hidden="true"></i></span>&nbsp;total_length &nbsp;<span
                                        class="span-alexa">58863</span> </p>
                                <hr>
                                <p class="p-alexa"><span><i class="fa fa-check blog-bgstate"
                                            aria-hidden="true"></i></span>&nbsp; text_length &nbsp;<span
                                        class="span-alexa">30490</span> </p>
                                <hr>
                                <p class="p-alexa"><span><i class="fa fa-check blog-bgstate"
                                            aria-hidden="true"></i></span>&nbsp; ratio &nbsp;<span
                                        class="span-alexa">51.798243378693</span> </p>
                                <hr>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="bg-blog-blue-s">
                    <div class="row">
                        <div class=" col-lg-4 col-md-6 col-12">
                            <div class="state-sec-ssl">
                                <p class="heading-blogblue">SSL Details</p>
                                <p class="SSL-Details">SSL Issuer: </p>
                                <p class="p-alexa"><b> Issuer:</b><span class="span-alexa"> Starfield Secure
                                        Certificate Authority - G2 </span> </p>
                                <hr>
                                <p class="p-alexa"><b> Valid From:</b><span class="span-alexa"> 2021-01-05 07:34:23
                                    </span> </p>
                                <hr>
                                <p class="p-alexa"><b>Expiration Date:</b><span class="span-alexa"> 2022-02-04
                                        07:34:23 </span> </p>
                                <hr>
                            </div>

                        </div>
                        <div class=" col-lg-4 col-md-6 col-12">
                            <div class="state-sec-ssl">
                                <p class="heading-blogblue" style="visibility: hidden;">SSL Organization:</p>
                                <p class="SSL-Details">SSL Organization: </p>
                                <p class="p-alexa"><b> Signature </b><span class="span-alexa"> Starfield
                                        Technologies, Inc </span> </p>
                                <hr>
                                <p class="p-alexa"><b> Algorithm: </b><span class="span-alexa"> RSA-SHA256 </span>
                                </p>
                                <hr>

                            </div>

                        </div>
                    </div>
                </div>
            </div>




            <div class="row">
                <div class="col-12 col-md-10">
                    <div class="middle-sec mt-4 mb-4">
                        <h4>Top Alternative to {{ $post->slug }} & <br> Websites like {{ $post->slug }}
                        </h4>
                    </div>

                </div>
            </div>




            @foreach ($post->domain_alternative as $alternative)


            @if ($alternative->status == 'publish')
            <?php 
              $alternative_data = alternative_data($alternative->slug);
            ?>

            <div class="beener">
                <div class="row">
                    <div class="col-12 col-md-3">
                        <div class="cc">
                            <div class="custome-bage">
                                <span class="custome-1232">
                                    {{ $loop->iteration }}
                                </span>
                            </div>

                            <img class="img-fluid  mt-2"
                                src="https://s3.us-west-1.wasabisys.com/{{ config('filesystems.disks.wasabi.bucket') }}/scrape/thumbnail/{{ $alternative_data->thumbnail }}">
                        </div>
                    </div>

                    <div class="col-12 col-md-5">
                        <h2>Sites like {{ $alternative_data->slug ?? "" }}</h2>
                        <h3>{{ $alternative_data->seo_analyzers_relation->domain_title ?? ""}}</h3>
                        <p>{{ $alternative_data->seo_analyzers_relation->domain_description ?? "" }}</p>
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header custome-bbtn" id="flush-headingOne">
                                    <button class="accordion-button collapsed dutton-1478" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                        aria-expanded="false" aria-controls="flush-collapseOne">
                                        More info &nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">N/A question_answer How exactly does the scan work with
                                        PlagAware? PlagAware's scan engine is based on the award-winning FullScan
                                        algorithm That ensures that every sentence of your work is really analyzed. The
                                        algorithm
                                        was recently awarded the title "Best Plagiarism Detection for German Texts"
                                        (Network for Academic Integrity, 2020).</div>
                                </div>
                            </div>
                        </div>

                        <!-- <p>More info &nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i></p> -->

                    </div>
                    <div class="col-12 col-md-4">
                        <a class="btn btn-meta btn-light ">
                            <img class="img-fluid" src="{{ asset('themes/manvendra/assets/images/4.png') }}">
                            {{ $alternative->ip ?? "" }}
                        </a>

                        <a class="btn btn-meta btn-light ">
                            <img class="img-fluid" src="{{ asset('themes/manvendra/assets/images/5.png') }}">
                            {{ $alternative_data->ip_record_relation->country_name ?? "" }}
                        </a>

                        <a class="btn btn-meta btn-light ">
                            <img class="img-fluid" src="{{ asset('themes/manvendra/assets/images/ssl.png') }}">
                            {{ (($alternative_data->Ssl_Details_relation->isValid == 1) ? 'Valid SSL' : 'InValid
                            SSL') ?? "" }}
                        </a>

                        <a href="{{ route('post.show',['post'=>$alternative->slug]) }}"
                            class="btn btn-success btn-product">Site Like {{
                            ucfirst($alternative->slug) }}</a>
                    </div>
                </div>



            </div>

            @endif


            @endforeach



        </div>
    </div>
</section>
<!-- end of like-->
@endsection