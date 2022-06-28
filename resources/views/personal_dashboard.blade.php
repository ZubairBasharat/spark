@extends('components.app')
@section('content')
    <style>
      .hover_properties {
        box-shadow: -10px -10px 0px 0px #48403d !important; 
        opacity: 1 !important;
        -webkit-transform: translate(10px, 10px) !important;
        transform: translate(10px, 10px) !important;
         z-index: 5 !important;
      }
    </style>
    <section class="theme-container">
      <div>
        <div class="progress-wrapper bg-white">
          <div class="progress-container mx-auto">
            <ul class="progress-steps ps-0 mb-0">
              <li data-counter="1" class="active"></li>
              <li data-counter="2"></li>
              <li data-counter="3"></li>
              <li data-counter="4"></li>
            </ul>
          </div>
        </div>
        <div class="end mt-20 mb-20">
          <a href="{{url('export-report')}}" style="text-decoration: none;"><button class="export-report">Export REPORT</button></a>
        </div>
        <div class="row">
          <div class="col-lg-6 col-12">
            <div class="personal-db-info">
              <h6>Your Personal Dashboard</h6>
              <h1>Hi {{Session::get('user_name')}}!</h1>
              <h2>Your Engagement State: <span class="text-red">{{isset($states[$phase_code]) ?  $states[$phase_code] : ''}}</span></h2>
              <h3>Definition of {{isset($states[$phase_code]) ?  $states[$phase_code] : ''}}</h3>
              <div class="more_data_content mb-4">
                @php
                $description = "";
                if(isset($states[$phase_code])){
                $state = str_replace(' ', '',$states[$phase_code]);

                    $description = $phase_code_description[$state];
                }
                @endphp
                {!!$description!!}
              </div>
              <!-- <p>
                Cras vel tortor nec nunc porttitor ornare pellentesque et est. Nam viverra sollicitudin molestie.
                Pellentesque sed mi convallis sapien aliquet consequat sed vel nunc. Donec viverra cursus magna. Fusce
                sollicitudin leo elit, at fermentum enim maximus vel. Cras ac finibus elit. Ut sed aliquam dolor. Duis a
                velit vitae velit consequat fringilla quis id tortor.
              </p> -->
              <button class="theme-btn mb-5 more_btn">MORE ABOUT YOU</button>
            </div>
          </div>
          <div class="col-lg-6 col-12">
            <div class="report-blocks-main">
              <div class="head">
                <img src="{{asset('/assets/images/blocks-logo.png')}}" height="32px" alt="logo" />
              </div>
              <div class="body">
                <h5 class="progress-text meaning" style="left:50px;">Meaning</h5>
                <div class="blocks">
                  <img src="{{asset('/assets/images/arrow-up.svg')}}" alt="arrow" class="arrow-up" />
                  <img src="{{asset('/assets/images/arrow-right.svg')}}" alt="arrow" class="arrow-right" />
                  <div class="d-flex flex-wrap">
                    <div class="block center flex-column @if(isset($states[$phase_code])) {{$states[$phase_code] == 'Frustrated' ? 'hover_properties' : ''}} @endif frustrated">
                      <h2>Frustrated</h2>
                      <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#frustrated-modal">Learn More</a>
                    </div>
                    <div class="block center flex-column @if(isset($states[$phase_code])) {{$states[$phase_code] == 'Energized' ? 'hover_properties' : ''}} @endif energized">
                      <h2>Energized</h2>
                      <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#energized-modal">Learn More</a>
                    </div>
                    <div class="block center flex-column pers-engaged @if(isset($states[$phase_code])) {{$states[$phase_code] == 'Passionately Engaged' ? 'hover_properties' : ''}} @endif">
                      <h2>Passionately Engaged</h2>
                      <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#pass-engage-modal">Learn More</a>
                    </div>
                    <div class="block center flex-column @if(isset($states[$phase_code])) {{$states[$phase_code] == 'Unfulfilled' ? 'hover_properties' : ''}} @endif unfilled">
                      <h2>Unfulfilled</h2>
                      <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#unfilled-modal">Learn More</a>
                    </div>
                    <div class="block center flex-column @if(isset($states[$phase_code]))  {{$states[$phase_code] == 'Neutral' ? 'hover_properties' : ''}} @endif neutral">
                      <h2>Neutral</h2>
                      <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#neutral-modal">Learn More</a>
                    </div>
                    <div class="block center flex-column @if(isset($states[$phase_code])) {{$states[$phase_code] == 'Engaged' ? 'hover_properties' : ''}} @endif  engaged">
                      <h2>Engaged</h2>
                      <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#engage-modal">Learn More</a>
                    </div>
                    <div class="block center flex-column stagnated @if(isset($states[$phase_code])) {{$states[$phase_code] == 'Stagnated' ? 'hover_properties' : ''}} @endif last">
                      <h2>Stagnated</h2>
                      <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#stagnated-modal">Learn More</a>
                    </div>
                    <div class="block center flex-column disconnected @if(isset($states[$phase_code])) {{$states[$phase_code] == 'Disconnected' ? 'hover_properties' : ''}} @endif last">
                      <h2>Disconnected</h2>
                      <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#disconnected-modal">Learn More</a>
                    </div>
                  </div>
                </div>
                <h5 class="progress-text">Progress</h5>
              </div>
            </div>
          </div>
        </div>
        <h1 class="section-title">How We Identify Your Engagement State</h1>
        <div class="row">
          <div class="col-lg-6">
            <div class="chart-main">
              <div class="head">
                <h2>Meaning</h2>
              </div>
              <div class="body">
                <canvas id="meaning-chart" height="60"></canvas>
                <div class="text-center">
                  <ul class="list-unstyled mb-0 indicator-container list-inline">
                    <li class="list-inline-item mt-3 me-4">
                      <span class="chart-indicator red me-2"></span>&nbsp;Your Score
                    </li>
                    <li class="list-inline-item mt-3">
                      <span class="chart-indicator orange me-2"></span>&nbsp;Others in the world
                    </li>
                  </ul>
                </div>
                <div class="chart-seperate-border"></div>
                <canvas id="meaning-group-chart" height="auto"></canvas>
                <div class="text-center">
                  <ul class="list-unstyled mb-0 indicator-container list-inline">
                    <li class="list-inline-item mt-3 me-4">
                      <span class="chart-indicator red me-2"></span>&nbsp;You
                    </li>
                    <li class="list-inline-item mt-3 grey">
                    <span class="chart-indicator grey me-2"></span>&nbsp;Others in the world
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="chart-main">
              <div class="head">
                <h2>Progress</h2>
              </div>
              <div class="body">
                <canvas id="progress-chart" height="60"></canvas>
                <div class="text-center">
                  <ul class="list-unstyled mb-0 indicator-container list-inline">
                    <li class="list-inline-item mt-3 me-4">
                      <span class="chart-indicator red me-2"></span>&nbsp;Your Score
                    </li>
                    <li class="list-inline-item mt-3">
                      <span class="chart-indicator orange me-2"></span>&nbsp;Others in the world
                    </li>
                  </ul>
                </div>
                <div class="chart-seperate-border"></div>
                <canvas id="progress-group-chart" height="auto"></canvas>
                <div class="text-center">
                  <ul class="list-unstyled mb-0 indicator-container list-inline">
                    <li class="list-inline-item mt-3 me-4">
                      <span class="chart-indicator red me-2"></span>&nbsp;You
                    </li>
                    <li class="list-inline-item mt-3 grey">
                    <span class="chart-indicator grey me-2"></span>&nbsp;Others in the world
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <p class="chart-desc-p">
          This shows the extent to which you see your career, your day-to-day work and the work you did a year ago as
          Meaningful. Our sense of Personal Meaning at work is determined by these three aspects. The same is true for
          Progress.
        </p>
        <p class="chart-desc-p">
          Your answers to these six questions describes your predominant emotion, as described above as your Engagement
          State. Notice if there is a difference between current work/career and past work. If the current work score is
          higher, ask yourself what has changed for the better? If the score is lower, ask yourself what has changed to
          reduce Meaning and/or Progress?
        </p>
        <p class="chart-desc-p">
          Also notice if there are differences between current work and career. If Meaning and/or Progress are higher in
          one, ask yourself what’s holding the other back?
        </p>
        <p class="chart-desc-p">
          This data is a great way to explore how you are experiencing your current work and how you are feeling about
          your career.
        </p>
      </div>
      <div class="dougnut-chart-main">
        <div class="head">
          <h2>You Compared to Others in the world</h2>
        </div>
        <div class="body">
          <div class="dougnut-chart-container">
            <canvas id="dougnut-chart" height="auto"></canvas>
          </div>
        </div>
        @if(count($myactions) > 0)
        <div class="head mt-4">
          <h2>How you feel about your company</h2>
        </div>
        @endif
        <div>
        @if(count($myactions) > 0) <p class="text-center">Employee loyalty, Retention & Advocacy for where you work</p> @endif
          @include('components.Personal_charts')
        </div>
      </div>
      <div class="center flex-wrap flex-md-nowrap">
        <a href="{{url($resume?'driver-action-plans':'myActionPlans')}}" style="text-decoration: none;"><button class="theme-btn me-md-2">{{$resume?"Resume":"Start"}} action planning</button></a>
        <a href="{{url('export-report')}}" style="text-decoration: none;"><button class="theme-btn hover w-238 mt-4 mt-md-0">Export Report</button></a>
      </div>
    </section>
    <div>
      <img src="{{asset('assets/images/bottom-layer.svg')}}" alt="bottom Layer" class="w-100" />
    </div>
    <footer id="site-footer"></footer>
    <!-- Modals -->
    <div class="modal fade" id="frustrated-modal" tabindex="-1" aria-labelledby="frustrated-modalLabel" aria-hidden="true">
      <div class="modal-dialog full-modal">
        <div class="modal-content">
          <div class="modal-body">
            <div class="modal-banner" style="background-image: url({{asset('assets/images/res1.png')}});">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <h1>Frustrated</h1>
            <p>
              In this state you may find yourself feeling exasperated because your sense of 
              progress is less that you hoped for or expected. There might be specific things you 
              want to achieve or a change you would like to bring into the workplace or into your 
              work product; however, the pace of progress is likely unsatisfying for you on some level.  As a result, you might find it challenging to find things to celebrate. This state
              indicates that you see your work as highly meaningful and because of this it may 
              also be true that you feel some pressure to make things happen. This caring can lead to high levels of activity (trying to do too much) that could become stressful over time. In some instances it might even cause you to obsess.
            </p>
            <p>
              Often, a facet of obsessing is a tendency to allow failures at work to play on one's 
              mind. This may be because failures are seen as a missed opportunity to create 
              forward movement, which may cause further frustration because you care so much.
            </p>
            <p>
              In this state, your work offers some fulfillment but because passion is also fueled by 
              progress, the lack of forward movement you sometimes experience can become an 
              energy drain. Without a high sense of progress, work may not be quite as much fun,
              perhaps making it difficult, at times, to stay inspired.  When this happens work may 
              feel too much like work, especially when everything seems to be a high priority. During these times, you may feel so busy that you don't seem to have time to think.
              The upside is that time does pass fairly quick.
            </p>
            <div class="center pt-3">
              <button type="button" class="theme-btn" data-bs-dismiss="modal">Return to My Personal Dashboard </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="energized-modal" tabindex="-1" aria-labelledby="energized-modalLabel" aria-hidden="true">
      <div class="modal-dialog full-modal">
        <div class="modal-content">
          <div class="modal-body">
            <div class="modal-banner" style="background-image: url({{asset('assets/images/energized-bg.png')}});">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <h1>Energized</h1>
            <p>
              In this state you likely find your work fulfilling and fairly challenging. You are likely taking action against things that matter to you. You appear to be a doer. Your scores indicate your overall engagement is drive more by a high sense of meaning,
              as your sense of progress is somewhat lower. You do celebrate some of your 
              accomplishments but it may be that others you do not deem worthy of celebration.
            </p>
            <p>Your strength is you see your work as highly meaningful. You seem to have a sense of purpose and to feel emotionally invested in your work. It is probable that this is highly motivating for you.</p>
            <p>You also report a healthy sense of progress.  It appears that for the most part, you can see the impact of your actions and, as a result, feel a sense of forward movement. This sense of progress seems to energize you.</p>
            <p>It is likely that when your sense of progress is strongest, you celebrate your achievements. This acknowledgement of success has the added benefit of reinforcing both meaning and progress, as we celebrate what is meaningful to us and what tells us we are getting somewhere. You tend to feel good about the contributions you are making at work. </p>
            <p>In this state, it is probable that your current work and career are fulfilling. You may find your word challenging thereby seeing your talents and skills being put to good use. Therefore, imaginably you are also learning and growing. As a result, you may find it easy to focus on your work and identify with your work. You may, at times, feel as if you care more than others, as your work appears to mean more to you than a paycheck.</p>
            <p>With this profile, it is unlikely that you need to dream about other possibilities, as your current work seems to allow you to take action against those things that are  meaningful to you. You are likely a doer and you usually know how to take your ideas and make them happen. The actions you take at work are prone to energize youand you generally look forward to coming to work. You are apt to sustain fairly intense action without it draining you.It is apt on most days, you end your day feeling good with energy to spare, which you may devote to your outside work interests</p>
            <div class="center pt-3">
              <button type="button" class="theme-btn" data-bs-dismiss="modal">Return to My Personal Dashboard </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="pass-engage-modal" tabindex="-1" aria-labelledby="pass-engage-modalLabel" aria-hidden="true">
      <div class="modal-dialog full-modal">
        <div class="modal-content">
          <div class="modal-body">
            <div class="modal-banner" style="background-image: url({{asset('assets/images/pass-engaged-bg.png')}});">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <h1>Passionately Engaged</h1>
            <p>
              In this state of work you are likely energized, as you probably feel challenged and 
              have a high sense of fulfillment. You are prone to take action on goals that matter to you and you are apt to celebrate your achievements. You appear to work at an appropriate pace and you tend not to obsess. Your scores indicate that you have both a sense of high meaning and progress at work.
            </p>
            <p>Your scores indicate that you see your work as of the highest meaning. It is therefore probable that yu have a clear sense of purpose and feel emotionally connected to your work. You are likely highly motivated.</p>
            <p>Your scores also indicate that you have the highest sense of progress.  Given this, you very likely see the impact of your actions and, as a result, feel a significant amount of forward movement. This sense of progress is apt to energize you. You see progress in your current work as well as your career in general. This progress ill tend to create resilience and fuel your motivation.</p>
            <p>You are also likely skilled at observing progress and you may recognize the benefit of celebrating your achievements as this creates a virtuous cycle: the acknowledgement of accomplishments reinforces both that which is meaningful to you as well as highlights the progress you have made. Celebration signals to us that we are getting somewhere toward that which matters most to us</p>
            <p>Your current work and career appear to be fulfilling. You generally do not need to dream about other possibilities as your current work allows you to take action against those things that are meaningful to you. You may also see your talents and skills being put to use as your work challenges you. You likely feel good about the contributions you are making at work.</p>
            <p>In this state, you are disposed to learn and grow. You have probably developed the ability to learn from your mistakes so are accepting that mistakes will happen. You therefore may have a healthy attitude toward mistakes.</p>
            <p>In this state, it is common to feel fully engaged when at work while not leaving work
              exhausted. Work likely energizes you and so you have energy for your activities and
              interests outside of work."
            </p>
            <div class="center pt-3">
              <button type="button" class="theme-btn" data-bs-dismiss="modal">Return to My Personal Dashboard </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="unfilled-modal" tabindex="-1" aria-labelledby="unfilled-modalLabel" aria-hidden="true">
      <div class="modal-dialog full-modal">
        <div class="modal-content">
          <div class="modal-body">
            <div class="modal-banner" style="background-image: url({{asset('assets/images/res1.png')}});">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <h1>Unfulfilled</h1>
            <p>
              In this state you may find your work doesn't provide you with the sense of 
              fulfillment you desire. This situation may sometimes cause you to lack energy both 
              at work and outside of work. Your work does hold some meaning for you but you are
              not able to see the progress you desire. As a result, experiencing a sense of 
              fulfillment, consistently at work, is perhaps difficult. The domino effect of this could 
              be that you tend not to celebrate, which may further prevent you from experiencing
              a reliable sense of accomplishment, thereby progress.
            </p>
            <p>You likely have deep aspirations and ambitions that you yearn to achieve and it 
              may appear that your current work experience is not supporting movement in this 
              direction, hence your pace of progress may feel too slow. You may even puzzle over
              others' enthusiasm. On some days, you may find yourself considering other work 
              but you also worry about the financial impact of change
              It could also be that you sometimes doubt whether your current work will provide 
              opportunities to fulfill these aspirations or help you achieve your potential. These 
              doubts, over time, may effect your self-esteem or self-confidence if you don't 
              manage this situation to your benefit
            </p>
            <div class="center pt-3">
              <button type="button" class="theme-btn" data-bs-dismiss="modal">Return to My Personal Dashboard </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="neutral-modal" tabindex="-1" aria-labelledby="neutral-modalLabel" aria-hidden="true">
      <div class="modal-dialog full-modal">
        <div class="modal-content">
          <div class="modal-body">
            <div class="modal-banner" style="background-image: url({{asset('assets/images/neutral-bg.png')}});">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <h1>Neutral</h1>
            <p>
              In this state, you likely find your work somewhat challenging and somewhat 
              fulfilling. Your score indicates that your sense of meaning and progress are typical, 
              meaning they fall in the average zone (neither high nor low). You get your work 
              done and take things in stride; in other words, you tend not to get too worked up 
              about things. You celebrate some of your accomplishments however may miss 
              opportunities to celebrate other achievements, as you may deem them less 
              significant and so less worthy of celebration.
            </p>
            <p>
              Your score indicates that you see your work as somewhat meaningful and you are 
              seeing some progress. This is the most common profile in our database. 
              Statistically, it is deemed "the average." In other words, people in this state may 
              enjoy their work but there may be room to deepen one's connection to meaning and
              to increase the opportunities to make progress visible
              A common characteristic of this state is not getting too fussed about mistakes. You 
              pretty much go with the flow.
            </p>
            <p>
              Time goes neither too slowly nor does it fly. You 
              appear to have enough work to keep you occupied and productive without 
              becoming too busy or overwhelmed.  This state indicates that in many ways you are
              comfortable with your work. In this state, it is likely that your work neither 
              aggravates you nor really jazzes you.
              You have enough meaning and progress to engage in at least some facets of your 
              work. In other words, you have enough to buffer you from the negative areas but 
              you might need a boost to move you into the states of Energized, Engaged, or 
              Passionately Engaged
            </p>
            <div class="center pt-3">
              <button type="button" class="theme-btn" data-bs-dismiss="modal">Return to My Personal Dashboard </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="modal fade" id="engage-modal" tabindex="-1" aria-labelledby="engage-modalLabel" aria-hidden="true">
      <div class="modal-dialog full-modal">
        <div class="modal-content">
          <div class="modal-body">
            <div class="modal-banner" style="background-image: url({{asset('assets/images/res1.png')}});">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <h1>Engaged</h1>
            <p>
              In this state you may experience a good measure of fulfillment at work and you likely take time to celebrate your accomplishments. You are apt to have some resilience and are probably not driven crazy or frustrated by most matters. Therefore, you tend not to obsess; however, work is likely very important to you and contributes significantly to your sense of identity. Your scores indicate that your engagement is driven more by a sense of high progress, as your meaning scores 
              are somewhat lower. Nevertheless, you do see a good amount of meaning in your work. Your scores indicate you have a sense of purpose and feel emotionally connected to your work.
            </p>
            <p>
              Your scores indicate a very healthy sense of progress.  For the most part, you appear to see the impact of your actions and, as a result, feel a sense of forward movement. This sense of progress likely energizes you. In fact, in this state of work, progress is a distinguishing driver of engagement.
              When your sense of progress is strongest, you are apt to celebrate your achievements. This acknowledgement of your accomplishments has the added benefit of reinforcing both meaning and progress, as we tend to celebrate what is meaningful to us and what tells us we are getting somewhere. You are prone to feeling good about the contributions you are making at work
            </p>
            <p>
              Your current work and career are likely fulfilling. You may also see your talents and 
              skills being put to use as your work challenges you. In this state, it is quite possible 
              that you are also learning and growing. As a result, you may find it easy to focus on 
              your work and you may identify strongly with it. At times, you might feel as if you care more than others, as your work likely means more to you than a paycheck.
            </p>
            <div class="center pt-3">
              <button type="button" class="theme-btn" data-bs-dismiss="modal">Return to My Personal Dashboard </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="modal fade" id="stagnated-modal" tabindex="-1" aria-labelledby="stagnated-modalLabel" aria-hidden="true">
      <div class="modal-dialog full-modal">
        <div class="modal-content">
          <div class="modal-body">
            <div class="modal-banner" style="background-image: url({{asset('assets/images/res1.png')}});">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <h1>Stagnated</h1>
            <p>
              In this state you may find your work fairly unchallenging or not as fulfilling as you 
              would like. This could result, at times, in feeling disengaged from your work. As a 
              result, time may drag and you might find yourself living for your interests outside ofwork. You might also struggle to find reasons to celebrate as your work may not 
              give you the sense of accomplishment you desire. The sense of meaning and 
              progress at work you crave may feel low compared to what you have previously 
              known. You may notice on some days, or perhaps even many days, you find  yourself yearning for more.
            </p>
            <p>
              It could be that your aspirations and long-term goals may be unclear to you or you 
              do not see how they can be achieved within your current work and career situation, 
              which will likely reduce the meaning you see in your work. This has left you feeling somewhat at a standstill.
            </p>
            <p class="text-black">
              This may be compounded by the fact that your work is not challenging enough for 
              you. In fact, it might be too easy for you.  You desire to use fully your talents and to also continue to learn and grow.  You may find that your sense of progress at work 
              is held back without this stimulation. It may also mean that you worry about having 
              the opportunity in your current work to achieve your potential. This situation, when prevalent for longer periods of time, may begin to impact your self-esteem or self-confidence.
            </p>
            <p>
              All in all, this work experience may leave you feeling a lack of momentum, as you 
              are not actively working toward personally meaningful goals at work; however, your
              heart's desire is likely much deeper engagement
            </p>
            <div class="center pt-3">
              <button type="button" class="theme-btn" data-bs-dismiss="modal">Return to My Personal Dashboard </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="modal fade" id="disconnected-modal" tabindex="-1" aria-labelledby="disconnected-modalLabel" aria-hidden="true">
      <div class="modal-dialog full-modal">
        <div class="modal-content">
          <div class="modal-body">
            <div class="modal-banner" style="background-image: url({{asset('assets/images/res1.png')}});">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <h1>Disconnected</h1>
            <p>
              In this state you reported experiencing a strong sense of progress. This functions as
              a strength for you. You also reported that your overall meaning is significantly lower than your sense of progress. This situation may lead to a work experience in which you get your work done but you may not get a great deal of joy from it. Nonetheless, you have ownership for your work and you do move your tasks/objectives forward.
            </p>
            <p>
              This profile usually indicates that you are responsible at work in that you meet your obligations. You likely have a sense of ownership for your work and how your work 
              is accomplished. It is also possible that you are able to make at least some decisions about how your work gets done. People with this profile generally have the skills to do their work; in fact, you may feel you have untapped potential.
            </p>
            <p>However, it is also often true that with this profile you do not have a strong connection to purpose, which may also be lowering you sense of meaning. In addition, you might feel that your work often goes unappreciated by others, especially outside of your immediate team. Sometimes, you (your position/work) may feel taken for-granted or under-valued. For example, you may not feel fully included in the flow of communications and you may not see how to offer your input.  It is possible that this may lead to a sense of being separate from the heartbeat of the organization or possibly over-focusing on your own area.</p>
            <p>
              Although a focus on your own work may give you a sense of healthy progress, you 
              may not know exactly how the progress you achieve connects to the organization's mission. This may lead to a tendency to neglect celebration.
            </p>
            <div class="center pt-3">
              <button type="button" class="theme-btn" data-bs-dismiss="modal">Return to My Personal Dashboard </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"
      integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    
    <script src="{{asset('/assets/js/charts.js')}}"></script>
   
    <script>
      "<?php if(count($phase_distribution) == 0){ ?>"
        var labels_ = ['DatA Not Available'];
        var data_= [1];
        "<?php }else{ ?>"
          var labels_ = [];
          var data_ = [];
          "<?php } ?>"
     
      "<?php
      foreach($phase_distribution as $index=>$phase){ ?>"
      labels_["<?= $index ?>"] = "<?= $states[$phase->phase_code] ?>";
      data_["<?= $index ?>"] = "<?= $phase->percentage ?>";
      "<?php } ?>"
      const myChart5 = new Chart(ctx5, {
    type: "doughnut",
    data: {
    labels: labels_,
    datasets: [
        {
        data: data_,
        backgroundColor: [
            "#7E706C",
            "#695D5A",
            "#584E4C",
            "#48403D",
            "#ED1846",
            "#F15A22",
            "#F47920",
            "#EAE8EA",
        ],
        borderColor: [
            "#7E706C",
            "#695D5A",
            "#584E4C",
            "#48403D",
            "#ED1846",
            "#F15A22",
            "#F47920",
            "#EAE8EA",
        ],
        borderWidth: [1, 1, 1, 1, 1, 1, 1, 1],
        datalabels: {
        anchor: 'end'
      },

        }
    ]
    },
    options: {
    responsive: true,
    tooltips: {
      callbacks: {
        label: function(tooltipItem, data) {
          return data['labels'][tooltipItem['index']] + ': ' + data['datasets'][0]['data'][tooltipItem['index']] + '%';
        }
      }
    },
    plugins: {
        legend: {
        position: 'left',
        labels: {
          fontColor: '#333',
          usePointStyle: true,
          borderRadius:10,
          padding:15
        }
        },
        datalabels: {
       formatter: (value, ctx) => {
         let datasets = ctx.chart.data.datasets;
         if (datasets.indexOf(ctx.dataset) === datasets.length - 1) {
           let sum = datasets[0].data.reduce((a, b) => a + b, 0);
           let percentage = Math.round((value / sum) * 100) + '%';
           return percentage;
         } else {
           return percentage;
         }
       },
       color: '#fff',
     },
        tooltip: {
        enabled: true,
        callbacks: {
          footer: (ttItem) => {
            let sum = 0;
            let dataArr = ttItem[0].dataset.data;
            dataArr.map(data => {
              sum += Number(data);
            });

            let percentage = (ttItem[0].parsed * 100 / sum).toFixed(2) + '%';
            return `Percentage of data: ${percentage}`;
          }
        }
      },
      datalabels: {
        color: 'blue',
        labels: {
          title: {
            font: {
              weight: 'bold'
            }
          },
          value: {
            color: 'green'
          }
        }
      }


      },
    },
});

const myChart3 = new Chart(ctx3, {
    type: "bar",
    data: {
        labels: ["Feeling Of Career meaning", "Feeling Of work meaning", "Feeling Of Past work meaning"],
        datasets: [
        {
            label: "You",
            backgroundColor: "#ED1846",
            borderColor: "#ED1846",
            borderWidth: 1,
            borderRadius: 4,
            borderRadius: 4,
            barThickness:20,
            data: ["<?= $question_values[0] ?>", "<?= $question_values[1] ?>", "<?= $question_values[2] ?>"],
        },
        {
            label: "Others in the world",
            backgroundColor: "#979797",
            borderColor: "#979797",
            borderRadius: 4,
            barThickness:20,
            data: ["<?= $contrast_values[0] ?>", "<?= $contrast_values[1] ?>", "<?= $contrast_values[2] ?>"]
        },
        ],
    },
    options: {
        indexAxis: "y",
        responsive: true,
        plugins: {
        legend: {
            display: false,
            position: "right",
        },
        title: {
            display: false,
            text: "Feeling Of Career meaning",
        },
        },
    },
    });

    const myChart4 = new Chart(ctx4, {
    type: "bar",
    data: {
    labels: ["Feeling Of Career meaning", "Feeling Of work meaning", "Feeling Of Past work meaning"],
    datasets: [
        {
        label: "You",
        backgroundColor: "#ED1846",
        borderColor: "#ED1846",
        borderWidth: 1,
        borderRadius: 4,
        barThickness:20,
        data: ["<?= $question_values[3] ?>", "<?= $question_values[4] ?>", "<?= $question_values[5] ?>"]
        },
        {
        label: "Others in the world",
        backgroundColor: "#979797",
        borderColor: "#979797",
        borderWidth: 1,
        borderRadius: 4,
        barThickness:20,
        data: ["<?= $contrast_values[3] ?>", "<?= $contrast_values[4] ?>", "<?= $contrast_values[5] ?>"]
        },
    ],
    },
    options: {
    indexAxis: "y",
    responsive: true,
    plugins: {
        legend: {
        display: false,
        position: "right",
        },
        title: {
        display: false,
        text: "Feeling Of Career meaning",
        },
    },
    },
});

const ctx1 = document.getElementById("meaning-chart").getContext("2d");
const myChart1 = new Chart(ctx1, {
    type: "bar",
    data: {
        labels: ["Your Score", "Others in the world"],
        datasets: [
        {
            label: "Feeling Of Overall Meaning",
            data: ["<?= ($question_values[0] + $question_values[1] + $question_values[2]) / 3 ?>", "<?= ($contrast_values[0] + $contrast_values[1] + $contrast_values[2]) / 3 ?>"],
            backgroundColor: ["#ED1846", "#F15A22"],
            borderColor: ["#ED1846", "#F15A22"],
            borderWidth: 1,
            borderRadius: 4,
            barThickness:20,
        },
        ],
    },
    options: {
        indexAxis: "y",
        responsive: true,
        plugins: {
        legend: {
            display: false,
            position: "right",
        },
        title: {
            display: true,
            text: "Feeling Of Overall Meaning",
        },
        },
    },
    });

    const ctx2 = document.getElementById("progress-chart").getContext("2d");
    const myChart2 = new Chart(ctx2, {
    type: "bar",
    data: {
        labels: ["Your Score", "Others in the world"],
        datasets: [
        {
            label: "Feeling Of Overall Progress",
            data: ["<?= ($question_values[3] + $question_values[4] + $question_values[5]) / 3 ?>", "<?= ($contrast_values[3] + $contrast_values[4] + $contrast_values[5]) / 3 ?>"],
            backgroundColor: ["#ED1846", "#F15A22"],
            borderColor: ["#ED1846", "#F15A22"],
            borderWidth: 1,
            borderRadius: 4,
            barThickness:20,
        },
        ],
    },
    options: {
        indexAxis: "y",
        responsive: true,
        plugins: {
        legend: {
            display: false,
            position: "right",
        },
        title: {
            display: true,
            text: "Feeling Of Overall Meaning",
        },
        },
    },
    });
    </script>
@endsection