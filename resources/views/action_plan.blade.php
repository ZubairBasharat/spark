@extends('components.app')
@section('content')
    <section class="p-md-5 p-4">
      <div class="px-4">
        <div class="progress-wrapper bg-white">
          <div class="progress-container mx-auto">
            <ul class="progress-steps ps-0 mb-0">
              <li data-counter="1"></li>
              <li data-counter="2" class="active"></li>
              <li data-counter="3"></li>
              <li data-counter="4"></li>
            </ul>
          </div>
        </div>
        @if(session('success_message'))
        <div id="alert_message" class="mt-3 alert alert-success alert-dismissible col-md-12">
          <strong>{{session('success_message')}}</strong>
        </div>
        @endif
        @if(session('error_message'))
        <div id="alert_message" class="mt-3 alert alert-danger alert-dismissible col-md-12">
          <strong>{{session('error_message')}}</strong>
        </div>
        @endif
        <div class="transform-heading mt-4 d-flex align-items-center">
          <h5 class="mb-0">My Action Plan</h5>
          <a href="{{url('action-plan')}}" class="ms-auto" style="text-decoration: none;"><button type="text" class="border-0 ">
            Export Action Plan
          </button></a>
        </div>
        <div class="mt-4 plan-heading pe-lg-5">
          <h5>HOW TO CREATE MY ACTION PLAN?</h5>
          <p class="mb-0">
            Understanding your state of {{$phase_code}} is the first step in
            self-managing your work experience. Once you have this
            self-awareness, you can take action!
          </p>
        </div>
        <section class="plan-video-section d-flex flex-wrap mt-4 align-items-center">
          <div class="position-relative plan-video">
            <!-- <video
              class="h-100"
              poster="{{asset('/assets/images/thumbnail.png')}}"
            ></video>
            <div class="position-absolute w-100 h-100 video-controls">
              <div class="rounded-circle first-circle button-circle">
                <div class="rounded-circle second-circle button-circle">
                  <div class="third-circle rounded-circle button-circle">
                    <button
                      type="button"
                      class="video-play-button rounded-circle d-flex align-items-center justify-content-center border-0"
                    >
                      <i class="bi bi-play-fill"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div> -->
            <div class="h-100 d-flex align-items-center">
              <img src="{{asset('/assets/images/with_ bg.svg')}}" class="img-fluid" alt="layer" />
            </div>
          </div>
          <div class="py-4 ps-lg-5 ps-4 pe-lg-4 pe-4 plans-detail">
            <h5 class="mb-3">Getting Started</h5>
            <ul class="mb-0 list-unstyled p-0">
              <li>Read the full description of your state of engagement.</li>
              <li>Next, check out the action ideas below.</li>
              <li>Read the list and see which ideas attract your interest.</li>
              <li>Click the Add to Action Plan button.</li>
              <li>Create your own actions with the Add New option!</li>
              <li>Save your action plan to date.</li>
            </ul>
          </div>
        </section>
        <section class="faq-ideas mt-4">
          <div class="my-5">
            <h5>Action Ideas for {{$phase_code}}</h5>
            <p class="mb-0">
              Review the suggestions from our research and clients below and see
              which ones will work for you!
            </p>
          </div>
          <div class="row">
            <div class="col-lg-8">
              <div class="accordion-box p-4">
                <div class="accordion" id="accordionExample">
                  @foreach($available_action_plans as $index=>$available_action_plan)
                  @php
                    if(in_array($available_action_plan->id, $myactions_ids_array))
                    continue;
                  @endphp
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="">
                      <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapse{{$index}}"
                        aria-expanded="true"
                        aria-controls=""
                      >
                        {{$available_action_plan->short_description}}
                      </button>
                    </h2>
                    <div
                      id="collapse{{$index}}"
                      class="accordion-collapse collapse"
                      aria-labelledby=""
                      data-bs-parent="#accordionExample"
                    >
                      <div class="accordion-body">
                        @php
                        $plan_description = "";
                         $plan = str_replace(' ', '',$available_action_plan->short_description);
                         if(isset($description[strtoupper($plan.'_'.$available_action_plan->phase_code)]))
                         $plan_description = $description[strtoupper($plan.'_'.$available_action_plan->phase_code)]
                        @endphp

                        {!!$plan_description!!}
                        <!-- <strong
                          >This is the first item's accordion body.</strong
                        >
                        It is shown by default, until the collapse plugin adds
                        the appropriate classes that we use to style each
                        element. These classes control the overall appearance,
                        as well as the showing and hiding via CSS transitions.
                        You can modify any of this with custom CSS or overriding
                        our default variables. It's also worth noting that just
                        about any HTML can go within the
                        <code>.accordion-body</code>, though the transition does
                        limit overflow. -->
                      </div>
                      <div class="transform-heading" style="background: none !important">
                      <!-- <a href="{{url('save-action-plan', $available_action_plan->id)}}"> -->
                        <button type="text" data-id="{{$available_action_plan->id}}" data-plan ="{{$available_action_plan->short_description}}" class="border-0 save_action_plan_btn">
                        Add Action Plan
                      </button>
                    <!-- </a> -->
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="accordion-box h-100">
                <div class="transform-heading">
                  <h6 class="mb-0">My action plan</h6>
                </div>
                <ul class="list-unstyled list-added-actions mb-0 px-4 my-2 myactions">
                  @foreach($myactions as $myaction)
                  <li class="mb-2">
                    <div class="d-flex py-2 align-items-center">
                      <h6 class="me-3 mb-0 me-2">
                        {{$myaction->action->short_description}}
                      </h6>
                      <a class="ms-auto border-0 bg-transparent p-0" href="{{url('delete-action',$myaction->id)}}/1">
                      <button
                        type="button"
                        class="ms-auto border-0 bg-transparent p-0"
                      >
                        <i class="bi bi-trash"></i>
                      </button>
                      </a>
                    </div>
                  </li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
        </section>
      </div>
      <div class="mx-auto text-center mt-5">
        <!-- <button
          type="button"
          disabled
          class="border-0 mx-auto print-btn rounded-pill f-medium px-4 text-uppercase"
        >
          Save Action PLAn
        </button> -->
      </div>
    </section>
    <div class="footer-layer-bottom">
      <img
        src="{{asset('/assets/images/bottom-layer.svg')}}"
        alt="bottom Layer"
        class="w-100"
      />
    </div>
    <footer id="site-footer"></footer>
    <div class="modal fade" id="confirmation_modal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="confirmation_modal_label" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body py-4">
            <div class="text-center">
              <img src="{{asset('assets/images/check-fill-circle.svg')}}" height="100px" />
              <p class="my-4">Your action plan has been saved successfully</p>
              <a href="{{url('/personal-dashboard?is_resume=true')}}" class="text-decoration-none dash-btn text-uppercase">Go to dashboard</a>
            </div>
          </div>
        </div>
      </div>
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
      $(document).on('click','.save_action_plan_btn',function(){
        $('.save_action_plan_btn').prop('disabled', true);
        var id = $(this).data('id');
        var plan = $(this).data('plan');
        var btn = $(this);
        $.ajax({
          'method' : 'POST',
          'url' : "{{url('save-action-plan')}}",
          'data' : {id: id, _token: "{{ csrf_token() }}"},
          success:function(response)
          {
            $('.save_action_plan_btn').prop('disabled', false);
            if(response.status_code == 200){
              btn.parent().parent().parent().remove();
              $('.myactions').append(`
                 <li class="mb-2">
                    <div class="d-flex py-2 align-items-center">
                      <h6 class="me-3 mb-0 me-2">
                          ${plan}
                      </h6>
                      <a class="ms-auto border-0 bg-transparent p-0" href="{{url('delete-action')}}/${response.id}">
                      <button
                        type="button"
                        class="ms-auto border-0 bg-transparent p-0"
                      >
                        <i class="bi bi-trash"></i>
                      </button>
                      </a>
                    </div>
                  </li>
                `);
                $('#confirmation_modal').modal('show');
            }else{
              alert("Some thing went wrong, Please try again later");
            }
          }
        });
      });
    </script>
 @endsection