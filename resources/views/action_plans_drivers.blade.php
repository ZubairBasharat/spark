@extends('components.app')
@section('content')
    <section class="p-md-5 p-4">
      <div class="px-4">
        <div class="progress-wrapper bg-white">
          <div class="progress-container mx-auto">
            <ul class="progress-steps ps-0 mb-0">
              <li data-counter="1" class="active"></li>
              <li data-counter="2" class="active"></li>
              <li data-counter="3" class="active"></li>
              <li data-counter="4" class="active"></li>
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
          <h5 class="mb-0">My Action Plan for My Engagement Drivers</h5>
          <a href="{{url('action-plan')}}" class="ms-auto" style="text-decoration: none;"><button type="text" class="border-0 ">
            Export Action Plan
          </button></a>
        </div>
        <div class="mt-4 plan-heading pe-lg-5">
          <h5>HOW TO DECIDE MY FOCUS</h5>
          <p class="mb-0">
            Now that you have a good understanding of your state of engagement and have personalized your action plan, it’s time to consider the underlying drivers of Meaning and Progress that give rise to your state of engagement.Now that you have a good understanding of your state of engagement and have personalized your action plan, it’s time to consider the underlying drivers of Meaning and Progress that give rise to your state of engagement.
          </p>
        </div>
        <section class="plan-video-section red d-flex flex-lg-nowrap flex-wrap mt-4 align-items-center">
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
            <h5 class="mb-3">Driving Your Engagement</h5>
            <ul class="mb-0 list-unstyled p-0">
              <li>Review Your Engagement Drivers identified as your STRENGTHS</li>
              <li>Decide on at least one to STRENGTHEN FURTHER</li>
              <li>Select ACTION IDEAS to add to your Action Plan.</li>
              <li>Review Your Engagement Drivers identified as your IMPROVEMENT AREAS.</li>
              <li>Select action ideas to add to Your Action Plan</li>
              <li>Save and Print Your Plan for easy reference</li>
            </ul>
          </div>
        </section>
        <section class="faq-ideas mt-4">
          <div class="my-5">
            <h5>Your Engagement Drivers + Action ideas {{--{{$phase_code}}--}}</h5>
            <p class="mb-0">
                Review the suggestions from our research and clients below and see which ones will work for you!
            </p>
          </div>
          <div class="row">
            <div class="col-lg-8">
              <div class="accordion-box p-4">
              <div class="accordion" id="innerAccordionMain">
                  <div class="accordion-item bg-transparent">
                    <h2 class="accordion-header" id="">
                      <button
                        class="accordion-button collapsed inner-btn"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapsemain1"
                        aria-expanded="true"
                        aria-controls=""
                      >
                      Action Ideas  For  Your driver strengths
                      </button>
                    </h2>
                    <div
                      id="collapsemain1"
                      class="accordion-collapse collapse"
                      aria-labelledby=""
                      data-bs-parent="#innerAccordionMain"
                    >
                      <div class="accordion-body px-2">
                      <div class="accordion" id="innerAccordion">
                        @foreach($available_action_plans as $index=>$available_action_plan)
                        @php
                          if(in_array($available_action_plan->id, $myactions_ids_array))
                          continue;
                        @endphp
                  <div class="accordion-item bg-transparent">
                    <h2 class="accordion-header" id="">
                      <button
                        class="accordion-button  collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseinner{{$index}}"
                        aria-expanded="true"
                        aria-controls=""
                      >
                        {{$available_action_plan->short_description}}
                      </button>
                    </h2>
                    <div
                      id="collapseinner{{$index}}"
                      class="accordion-collapse collapse"
                      aria-labelledby=""
                      data-bs-parent="#innerAccordion"
                    >
                      <div class="accordion-body">
                        {{isset($descriptions[$available_action_plan->id][$available_action_plan->short_description][$available_action_plan->threshold_low][$available_action_plan->threshold_high][$available_action_plan->question_id]) ? $descriptions[$available_action_plan->id][$available_action_plan->short_description][$available_action_plan->threshold_low][$available_action_plan->threshold_high][$available_action_plan->question_id] : ''}}
                      </div>
                      <div class="transform-heading" style="background: none !important">

                        <button type="text" data-id="{{$available_action_plan->id}}" data-plan ="{{$available_action_plan->short_description}}" data-plan ="4" class="border-0 save_action_plan_btn">
                        Add Action Plan
                      </button>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
                      </div>
                    </div>
                  </div>
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
                      <a class="ms-auto border-0 bg-transparent p-0" href="{{url('delete-action',$myaction->id)}}/2">
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
              <a href="{{url('/personal-dashboard')}}" class="text-decoration-none dash-btn text-uppercase">Go to dashboard</a>
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
      $(document).on('click','.save_action_plan_btn',function(){
        // $('.save_action_plan_btn').prop('disabled', true);
        var id = $(this).data('id');
        var plan = $(this).data('plan');
        var btn = $(this);
        $.ajax({
          'method' : 'POST',
          'url' : "{{url('save-action-plan-two')}}",
          'data' : {id: id, _token: "{{ csrf_token() }}"},
          success:function(response)
          {
           
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
            $('.save_action_plan_btn').prop('disabled', false);
          }
        });
      });
    </script>
 @endsection