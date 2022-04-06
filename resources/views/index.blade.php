@extends('components.app')
@section('content')
<section class="px-md-5 px-3">
    <div class="row mx-0 py-5 align-items-center">
        <div class="col-md-6">
            <div class="landing-content">
                <h6>Learn More About You</h6>
                <h3 class="f-bold text-red mt-3">
                    When you understand where you are today, you can create<br />
                    a plan for where you want to be tomorrow.
                </h3>
                <p class="mb-0 mt-5">
                    Your personalized, <b>Spark’dLens</b> profile will give you
                    insight into your current work experience and will give you the
                    information, insight and the tools to create your best work
                    experience.
                </p>
            </div>
        </div>
        <div class="col-md-6 mt-md-0 mt-5">
            <img src="{{('assets/images/home-layer.png')}}" alt="Curve Layer" class="img-fluid" />
        </div>
    </div>
    <div class="row mx-0 pb-5 align-items-center">
        <div class="col-md-6">
            <div class="auth-content pb-0">
                <h1>About Us</h1>
                <h6>
                    What is <span class="text-lred">Spark'd</span> and who’s it for?
                </h6>
                <p>
                    <b>Spark'd</b> Engagement is about consciously thinking and doing
                    things differently within organizations to create different
                    results.<br /><br />
                    Engaging people means connecting them to what is meaningful and
                    purposeful and creating environments that remove barriers to
                    inspired action and authentic interactions, resulting in progress
                    and exceptional performance.<br /><br />
                    Deep employee and team engagement fulfills the individual
                    personally and achieves remarkable results for the organization in
                    ways that traditional management practices cannot.<br /><br />
                    Passionate engagement requires innovative leadership development,
                    purpose-centered team work, and individual capability building to
                    host centered team building, and skills to host high-impact
                    actions and conversations. Spark’d Engagement provides the
                    knowledge, strategies and practices to achieve passionate
                    engagement in your workplace..
                </p>
                <div class="text-center">
                    <a href="#"
                        class="rounded-pill text-decoration-none bg-transparent text-uppercase btn-theme-outline">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-md-0 mt-4">
            <div class="border-clip">
                <img src="{{('assets/images/pexels-layer.png')}}" alt="Curve Layer" class="img-fluid" />
            </div>
        </div>
    </div>
</section>
<div>
    <img src="{{('assets/images/bottom-layer.svg')}}" alt="bottom Layer" class="w-100" />
</div>
@endsection