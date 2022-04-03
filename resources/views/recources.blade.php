@extends('components.app')
@section('content')
    <section class="main-wrap-resource px-5 py-5">
      <div class="pe-lg-5">
        <h5>Content Library</h5>
        <p class="mb-0 col-lg-10 heading-detail">
          At Spark'd, we want to support you by continuously updating our
          content and number of resources. If your question or need cannot be
          satisfied on this page, Contact Us to ask your question or submit your
          request.
        </p>
        <div class="text-end my-3">
          <select class="ms-auto">
            <option disabled value="" selected>Select Category</option>
            <option>Category 1</option>
          </select>
        </div>
      </div>
      <div class="row px-lg-4">
        <div class="col-lg-4 col-md-6 col-12 mt-4">
          <div class="res-box">
            <img
              src="{{asset('/assets/images/res1.png')}}"
              class="w-100"
              alt="recource1"
            />
            <div class="res-box-content p-4">
              <h6>Webinar Series for Individuals</h6>
              <p>
                Our three modules (approx. 10-minutes each) deepen your
                understanding and make you stand out among your collegues.
              </p>
              <a
                href="#"
                class="d-inline-flex align-items-center text-uppercase"
              >
                LEARN MORE&nbsp;<i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12 mt-4">
          <div class="res-box">
            <img
              src="{{asset('/assets/images/res2.png')}}"
              class="w-100"
              alt="recource2"
            />
            <div class="res-box-content p-4">
              <h6>Webinar for Managers!</h6>
              <p>
                Managers cannot make someone passionate but they can create the
                conditions that make it easier or more difficult!
              </p>
              <a
                href="#"
                class="d-inline-flex align-items-center text-uppercase"
              >
                LEARN MORE&nbsp;<i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12 mt-4">
          <div class="res-box">
            <img
              src="{{asset('/assets/images/res3.png')}}"
              class="w-100"
              alt="recource3"
            />
            <div class="res-box-content p-4">
              <h6>Spark'dTips</h6>
              <p>
                Sign up for our bi-weekly tip! 100% actionable and impactful!
              </p>
              <a
                href="#"
                class="d-inline-flex align-items-center text-uppercase"
              >
                LEARN MORE&nbsp;<i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12 mt-4">
          <div class="res-box">
            <img
              src="{{asset('/assets/images/res4.png')}}"
              class="w-100"
              alt="recource4"
            />
            <div class="res-box-content p-4">
              <h6>Spark'd Blog</h6>
              <p>
                Check out our blog from our founder and thought leader in
                engagement!
              </p>
              <a
                href="#"
                class="d-inline-flex align-items-center text-uppercase"
              >
                LEARN MORE&nbsp;<i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12 mt-4">
          <div class="res-box">
            <img
              src="{{asset('/assets/images/res5.png')}}"
              class="w-100"
              alt="recource5"
            />
            <div class="res-box-content p-4">
              <h6>Career Progress: Run your Race</h6>
              <p>
                We often leave our career in the hands of our manager or the
                organization. This three-part webinar series is full of tips and
                tricks!
              </p>
              <a
                href="#"
                class="d-inline-flex align-items-center text-uppercase"
              >
                LEARN MORE&nbsp;<i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12 mt-4">
          <div class="res-box">
            <img
              src="{{asset('/assets/images/res6.png')}}"
              class="w-100"
              alt="recource6"
            />
            <div class="res-box-content p-4">
              <h6>Executive Coaching Service</h6>
              <p>
                As a leader, your state of engagement influences everyone around
                you. Remove the obstacles to sustaining your passion at work and
                learn to support
              </p>
              <a
                href="#"
                class="d-inline-flex align-items-center text-uppercase"
              >
                LEARN MORE&nbsp;<i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div>
      <img
        src="{{asset('/assets/images/bottom-layer.svg')}}"
        alt="bottom Layer"
        class="w-100"
      />
    </div>
    <script
      type="text/javascript"
      src="{{asset('/assets/libraries/jquery/jquery.min.js')}}"
    ></script>
    <script type="text/javascript">
      $(window).on("load", function () {
        $("#spark-header").load("./layout/header.html");
        $("#site-footer").load("./layout/footer.html");
      });
    </script>
    @endsection