@extends('components.app')
@section('content')
<style type="text/css" media="print">
      footer,
      header,
      button,
      .footer-layer-bottom {
        display: none !important;
      }
      section {
        padding: 0px !important;
        margin: 0px !important;
      }
      .print-page {
        box-shadow: none;
        width:100% !important;
      }
      @page {
        margin-left:0;
        margin-right:0;
        margin-top:20px;
        size:auto;
      }
      .print-title {
        background: -moz-linear-gradient(
        90deg,
        #ffc20e 39.79%,
        rgba(255, 194, 14, 0.26) 100%
        );
        background: -webkit-linear-gradient(
        90deg,
        #ffc20e 39.79%,
        rgba(255, 194, 14, 0.26) 100%
        );
        background: -o-linear-gradient(
        90deg,
        #ffc20e 39.79%,
        rgba(255, 194, 14, 0.26) 100%
        );
        background: linear-gradient(
        90deg,
        #ffc20e 39.79%,
        rgba(255, 194, 14, 0.26) 100%
        );
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.0212249);
        border-radius: 8px;
        -webkit-border-radius: 8px; -moz-border-radius: 8px; border-radius: 8px;
        padding: 15px 20px;
      }
    </style>
    <section class="p-md-5 p-4 mt-md-4 mt-2">
      <div class="bg-white print-page p-4 col-lg-9 mx-auto">
        <div>
          <img src="{{asset('/assets/images/slide-logo.png')}}" alt="slide-logo" />
          <div class="print-content">
            @if(count($myactions) > 0)
            <div class="print-title my-4 text-center">
              <h5 class="mb-0">My Action Plan</h5>
            </div>
            @endif
            <div>
            @foreach($myactions as $index=>$myaction)
              <h4 class="text-uppercase">
                <i class="bi bi-star-fill"></i>&nbsp;&nbsp;{{$myaction->action->short_description}}
              </h4>
              <div class="px-md-4 px-2 px-xl-5 mt-4">
              @php
              $plan_description = "";
                $plan = str_replace(' ', '',$myaction->action->short_description);
                if(isset($description[strtoupper($plan.'_'.$myaction->action->phase_code)]))
                $plan_description = $description[strtoupper($plan.'_'.$myaction->action->phase_code)]
              @endphp

              {!!$plan_description!!}
                <!-- <p>
                  Your expectations for progress may be high. For example, you
                  may expect change to happen quickly or you may hope for large
                  shifts to occuror you may feel very impatient with the
                  inefficiencies and bureaucracy. If thisis the case, you may be
                  depriving yourself of a sense of progress. One way toinfuse
                  your day, week or month with a sense of achievement is to see
                  and celebrate the small wins.
                </p>
                <p>
                  Small wins are meaningful but small advances which, when
                  acknowledged,provide a reason to celebrate and as a result
                  uplift and encourage you. Theyalso help build resilience.
                </p>
                <div>
                  <h6>Examples of small wins:</h6>
                  <ul class="me-0 my-0 ps-3 ms-1">
                    <li>
                      - You finally got the task done that you'd been
                      postponing!
                    </li>
                    <li>
                      - You managed to get a colleague on side for a new project
                      idea.
                    </li>
                    <li>
                      - You had a very good conversation with a team member and
                      got to thebottom of a problem.
                    </li>
                    <li>
                      - You didn't buy any junk food from the vending machines
                      today!
                    </li>
                    <li>
                      - You figured out a piece of the solution to an ongoing
                      problem.
                    </li>
                    <li>- You chaired a meeting that went very well.</li>
                  </ul>
                </div> -->
              </div>
              <br>
              <br>
              @endforeach
              @if(count($myactions_two) > 0)
              <div class="print-title my-4 text-center">
                <h5 class="mb-0">Engagement Drivers</h5>
              </div>
              @endif
              <div>
              @foreach($myactions_two as $myaction_two)  
                <h4 class="text-uppercase">
                  <i class="bi bi-star-fill"></i>&nbsp;&nbsp;
                  {{$myaction_two->action->short_description}}
                </h4>
                <div class="px-md-4 px-2 px-xl-5">
                  <p>
                  {{isset($descriptions[$myaction_two->action->id][$myaction_two->action->short_description][$myaction_two->action->threshold_low][$myaction_two->action->threshold_high][$myaction_two->action->question_id]) ? $descriptions[$myaction_two->action->id][$myaction_two->action->short_description][$myaction_two->action->threshold_low][$myaction_two->action->threshold_high][$myaction_two->action->question_id] : ''}}
                  </p>
                </div>
              @endforeach  
                <!-- <h4 class="text-uppercase pt-3">
                  <i class="bi bi-star-fill"></i>&nbsp;&nbsp;Determine Purpose
                  Clarity
                </h4>
                <div class="px-md-4 px-2 px-xl-5">
                  <p>
                    Reflect on the extent to which you can support them:
                    Consider how they benefit your stakeholders, how they
                    support the mission and vision of your organization, and how
                    the values help create a healthy work environment
                  </p>
                </div>
                <h4 class="text-uppercase mt-5">
                  <i class="bi bi-star-fill"></i>&nbsp;&nbsp;Determine Purpose
                  Take action
                </h4>
                <div class="px-md-4 px-2 px-xl-5">
                  <p>
                    Reflect on the extent to which you can support them: Reflect
                    on the extent to which you can support them: Consider how
                    they benefit your stakeholders, how they support the mission
                    and vision of your organization, and how the values help
                    create a healthy work environment
                  </p>
                </div> -->
              </div>
            </div>
          </div>
          @if(count($myactions_two) == 0 && count($myactions) == 0)
            <h4 style="text-align: center;">You have not yet saved an action plan</h4>
          @endif
        </div>
      </div>
      <div class="col-lg-9 mx-auto text-center mt-5">
        <button
          type="button"
          class="border-0 mx-auto print-btn rounded-pill text-white f-medium px-4 text-uppercase"  @if(count($myactions_two) == 0 && count($myactions) == 0) disabled @endif
          @if(count($myactions_two) > 0 || count($myactions) > 0)
          onclick="window.print()"
          @endif
        >
          print pdf
        </button>
      </div>
    </section>
    <div class="footer-layer-bottom">
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
  @endsection
