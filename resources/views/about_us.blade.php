@extends('components.app')
@section('content')
<section class="main-wrap-auth" style="
        background: url({{asset('assets/images/about-layer.png')}});
        background-repeat: no-repeat;
        background-position: top -65px right;
      ">
    <div class="auth-content px-custom pe-lg-5 col-lg-7 col-xl-6">
        <div class="more_data_content">
            <h1 style="line-height: 1;">About Us</h1>
            <h6>
                What is <span class="text-lred">Spark'd</span> and who’s it for?
            </h6>
            <p class="pe-lg-4">
                <b>Spark'd</b> Engagement is about consciously thinking and doing
                things differently within organizations to create different
                results.<br />
                <br />Engaging people means connecting them to what is meaningful and
                purposeful and creating environments that remove barriers to inspired
                action and authentic interactions, resulting in progress and
                exceptional performance.<br />
                <br />
                Deep employee and team engagement fulfills the individual personally
                and achieves remarkable results for the organization in ways that
                traditional management practices cannot.<br />
                <br />
                Passionate engagement requires innovative leadership development,
                purpose-centered team work, and individual capability building to host
                centered team building, and skills to host high-impact actions and
                conversations. Spark’d Engagement provides the knowledge, strategies
                and practices to achieve passionate engagement in your workplace..
            </p>
        </div>
    </div>
    <div class="px-custom  more_container">
        <a href="#" class="rounded-pill more_btn text-decoration-none bg-transparent text-uppercase btn-theme-outline">
            Learn More
        </a>
    </div>
</section>
<div>
    <img src="{{asset('/assets/images/bottom-layer.svg')}}" alt="bottom Layer" class="w-100" />
</div>
@endsection