@extends('components.app')
@section('content')
    <section class="px-5 py-5">
      <div class="px-4">
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
        <div class="transform-heading mt-4 d-flex align-items-center">
          <h5 class="mb-0">My Action Plan</h5>
          <button type="text" class="border-0 ms-auto">
            Export Action Plan
          </button>
        </div>
        <div class="mt-4 plan-heading pe-lg-5">
          <h5>HOW TO CREATE MY ACTION PLAN?</h5>
          <p class="mb-0">
            Understanding your state of engagement is the first step in
            self-managing your work experience. Once you have this
            self-awareness, you can take action!
          </p>
        </div>
        <section class="plan-video-section d-flex mt-4 align-items-center">
          <div class="position-relative plan-video">
            <video
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
            <h5>Action Ideas for Frustrated</h5>
            <p class="mb-0">
              Review the suggestions from our research and clients below and see
              which ones will work for you!
            </p>
          </div>
          <div class="row">
            <div class="col-lg-8">
              <div class="accordion-box p-4">
                <div class="accordion" id="accordionExample">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                      <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseOne"
                        aria-expanded="true"
                        aria-controls="collapseOne"
                      >
                        Applaud Small Wins
                      </button>
                    </h2>
                    <div
                      id="collapseOne"
                      class="accordion-collapse collapse"
                      aria-labelledby="headingOne"
                      data-bs-parent="#accordionExample"
                    >
                      <div class="accordion-body">
                        <strong
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
                        limit overflow.
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                      <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo"
                        aria-expanded="false"
                        aria-controls="collapseTwo"
                      >
                        Find the Bright Spots
                      </button>
                    </h2>
                    <div
                      id="collapseTwo"
                      class="accordion-collapse collapse"
                      aria-labelledby="headingTwo"
                      data-bs-parent="#accordionExample"
                    >
                      <div class="accordion-body">
                        <strong
                          >This is the second item's accordion body.</strong
                        >
                        It is hidden by default, until the collapse plugin adds
                        the appropriate classes that we use to style each
                        element. These classes control the overall appearance,
                        as well as the showing and hiding via CSS transitions.
                        You can modify any of this with custom CSS or overriding
                        our default variables. It's also worth noting that just
                        about any HTML can go within the
                        <code>.accordion-body</code>, though the transition does
                        limit overflow.
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                      <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseThree"
                        aria-expanded="false"
                        aria-controls="collapseThree"
                      >
                        Focus on the Big Things
                      </button>
                    </h2>
                    <div
                      id="collapseThree"
                      class="accordion-collapse collapse"
                      aria-labelledby="headingThree"
                      data-bs-parent="#accordionExample"
                    >
                      <div class="accordion-body">
                        <strong
                          >This is the third item's accordion body.</strong
                        >
                        It is hidden by default, until the collapse plugin adds
                        the appropriate classes that we use to style each
                        element. These classes control the overall appearance,
                        as well as the showing and hiding via CSS transitions.
                        You can modify any of this with custom CSS or overriding
                        our default variables. It's also worth noting that just
                        about any HTML can go within the
                        <code>.accordion-body</code>, though the transition does
                        limit overflow.
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                      <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseFour"
                        aria-expanded="false"
                        aria-controls="collapseFour"
                      >
                        Focus on the Big Things
                      </button>
                    </h2>
                    <div
                      id="collapseFour"
                      class="accordion-collapse collapse"
                      aria-labelledby="headingFour"
                      data-bs-parent="#accordionExample"
                    >
                      <div class="accordion-body">
                        <strong
                          >This is the third item's accordion body.</strong
                        >
                        It is hidden by default, until the collapse plugin adds
                        the appropriate classes that we use to style each
                        element. These classes control the overall appearance,
                        as well as the showing and hiding via CSS transitions.
                        You can modify any of this with custom CSS or overriding
                        our default variables. It's also worth noting that just
                        about any HTML can go within the
                        <code>.accordion-body</code>, though the transition does
                        limit overflow.
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFive">
                      <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseFive"
                        aria-expanded="false"
                        aria-controls="collapseFive"
                      >
                        Focus on the Big Things
                      </button>
                    </h2>
                    <div
                      id="collapseFive"
                      class="accordion-collapse collapse"
                      aria-labelledby="headingFive"
                      data-bs-parent="#accordionExample"
                    >
                      <div class="accordion-body">
                        <strong
                          >This is the third item's accordion body.</strong
                        >
                        It is hidden by default, until the collapse plugin adds
                        the appropriate classes that we use to style each
                        element. These classes control the overall appearance,
                        as well as the showing and hiding via CSS transitions.
                        You can modify any of this with custom CSS or overriding
                        our default variables. It's also worth noting that just
                        about any HTML can go within the
                        <code>.accordion-body</code>, though the transition does
                        limit overflow.
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSix">
                      <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseSix"
                        aria-expanded="true"
                        aria-controls="collapseSix"
                      >
                        Applaud Small Wins
                      </button>
                    </h2>
                    <div
                      id="collapseSix"
                      class="accordion-collapse collapse"
                      aria-labelledby="headingSix"
                      data-bs-parent="#accordionExample"
                    >
                      <div class="accordion-body">
                        <div class="d-flex">
                          <div class="me-3">
                            <p>
                              Your expectations for progress may be high. For
                              example, you may expect change to happen quickly
                              or you may hope for large shifts to occuror you
                              may feel very impatient with the inefficiencies
                              and bureaucracy. If thisis the case, you may be
                              depriving yourself of a sense of progress. One way
                              toinfuse your day, week or month with a sense of
                              achievement is to see and celebrate the small
                              wins.
                            </p>
                            <p>
                              Your expectations for progress may be high. For
                              example, you may expect change to happen quickly
                              or you may hope for large shifts to occuror you
                              may feel very impatient with the inefficiencies
                              and bureaucracy. If thisis the case, you may be
                              depriving yourself of a sense of progress. One way
                              toinfuse your day, week or month with a sense of
                              achievement is to see and celebrate the small
                              wins.
                            </p>
                          </div>
                          <div>
                            <img
                              src="/assets/images/pie-user.svg"
                              alt="pie-chart"
                            />
                          </div>
                        </div>
                        <div class="print-content pe-xl-5">
                          <h6>Examples of small wins:</h6>
                          <ul class="me-0 my-0 ps-3 ms-1">
                            <li>
                              - You finally got the task done that you'd been
                              postponing!
                            </li>
                            <li>
                              - You managed to get a colleague on side for a new
                              project idea.
                            </li>
                            <li>
                              - You had a very good conversation with a team
                              member and got to thebottom of a problem.
                            </li>
                            <li>
                              - You didn't buy any junk food from the vending
                              machines today!
                            </li>
                            <li>
                              - You figured out a piece of the solution to an
                              ongoing problem.
                            </li>
                            <li>
                              - You chaired a meeting that went very well.
                            </li>
                          </ul>
                        </div>
                        <div class="d-flex flex justify-content-center">
                          <button
                            type="button"
                            class="btn-theme-outline me-3 mt-4 text-uppercase rounded-pill"
                            style="height: 30px"
                          >
                            edit
                          </button>
                          <button
                            type="button"
                            class="btn-theme-outline text-uppercase border-0 mt-4 bg-red text-white rounded-pill"
                            style="height: 30px"
                          >
                            Edit Action Plan
                          </button>
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
                <!-- <p
                  class="px-4 py-4 mb-0"
                  style="font-size: 14px; line-height: 1.5"
                >
                  You are yet to add an action plan, add action plans by opening
                  either of the dropdowns by your left hand side.
                </p> -->
                <ul class="list-unstyled list-added-actions mb-0 px-4 my-2">
                  <li class="mb-2">
                    <div class="d-flex py-2 align-items-center">
                      <h6 class="me-3 mb-0 me-2">
                        Find the bright spots
                      </h6>
                      <button
                        type="button"
                        class="ms-auto border-0 bg-transparent p-0"
                      >
                        <i class="bi bi-trash"></i>
                      </button>
                    </div>
                  </li>
                  <li>
                    <div class="d-flex py-2 align-items-center">
                      <h6 class="me-3 mb-0 me-2">
                        celebrate SMALL WINS
                      </h6>
                      <button
                        type="button"
                        class="ms-auto border-0 bg-transparent p-0"
                      >
                        <i class="bi bi-trash"></i>
                      </button>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </section>
      </div>
      <div class="mx-auto text-center mt-5">
        <button
          type="button"
          disabled
          class="border-0 mx-auto print-btn rounded-pill f-medium px-4 text-uppercase"
        >
          Save Action PLAn
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