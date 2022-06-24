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
    </style>
    <section class="p-md-5 p-4 mt-md-4 mt-2">
      <div class="bg-white print-page p-4 col-lg-9 mx-auto">
        <div>
          <img src="{{asset('/assets/images/slide-logo.png')}}" alt="slide-logo" />
          <div class="print-content">
            <div class="print-title my-4 text-center">
              <h5 class="mb-0">My Action Plan</h5>
            </div>
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
              <div class="print-title my-4 text-center">
                <h5 class="mb-0">Engagement Drivers</h5>
              </div>
              <div>
              @foreach($myactions_two as $myaction_two)  
                <h4 class="text-uppercase">
                  <i class="bi bi-star-fill"></i>&nbsp;&nbsp;Celebrate SMALL Get
                  {{$myaction_two->action->short_description}}
                </h4>
                <div class="px-md-4 px-2 px-xl-5">
                  <p>
                    Ensure you are clear on the values of your team/organization
                    and how they are defined in practice. For example, if
                    integrity is a value, reflect on what behaviors represent
                    integrity in the context of your organization. If you work
                    in insurance, it might be expressed by ensuring claims are
                    paid fairly and in a timely fashion, according to the
                    contract. Values are not theoretical notions but are defined
                    by behaviors that speak to how the work gets done within
                    your organization.
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
        </div>
      </div>
      <div class="col-lg-9 mx-auto text-center mt-5">
        <button
          type="button"
          class="border-0 mx-auto print-btn rounded-pill text-white f-medium px-4 text-uppercase"
          onclick="window.print()"
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
    <footer id="site-footer"></footer>
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
