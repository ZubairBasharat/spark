<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta author="Mian Roshan" content="Full Stack developer" />
    <title>Spark&nbsp;|&nbsp;Login</title>
    <link
      rel="stylesheet"
      type="text/css"
      href="../assets/libraries/bootstrap/bootstrap.min.css"
    />
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css" />
    <script
      type="text/javascript"
      src="../assets/libraries/jquery/jquery.min.js"
    ></script>
  </head>
  <body>
    <section
      class="main-wrap-auth slides-steps"
      style="
        background: url(../assets/images/steps-layer.png);
        background-repeat: no-repeat;
        background-position: top right;
      "
    >
      <nav class="px-custom auth-nav">
        <a href="#" class="d-inline-block">
          <img src="../assets/images/logo.png" width="290px" alt="Logo" />
        </a>
      </nav>
      <div class="px-custom col-lg-10 mx-auto col-xl-9 my-5">
        <div class="slide-box bg-white overflow-hidden active" id="slide-1">
          <div class="row">
            <div class="col-lg-6 pe-0">
              <div class="ps-3 pe-1 pt-5 pb-4">
                <blockquote class="pt-lg-5">
                  <!-- <blockquote class="f-rock start">“</blockquote> -->
                  <q class="mb-0 d-flex">
                    <span
                      >People often seek happiness at work. At
                      <b>Spark’d,</b> we focus on helping you achieve
                      fulfillment: Achieving high meaning in your work and
                      making on impact in ways that matter most to you.</span
                    >
                  </q>
                  <!-- <blockquote class="f-rock end">”</blockquote> -->
                </blockquote>
                <img
                  src="../assets/images/dots.svg"
                  alt="dots"
                  width="100%"
                  class="mt-5"
                />
              </div>
            </div>
            <div class="col-lg-6">
              <div
                class="px-3 py-4 h-100 position-relative bitmap-side"
                style="
                  background: url(../assets/images/Bitmap.png) no-repeat;
                  background-size: cover;
                "
              >
                <div
                  class="text-white position-relative h-100 d-flex flex-column justify-content-between"
                >
                  <div class="top-slide-content">
                    <h5>Jacqueline Throop-Robinson</h5>
                    <p>Founder, Spark Engagement</p>
                  </div>
                  <div>
                    <div class="d-flex flex-wrap justify-content-center">
                      <button
                        type="button"
                        data-id="slide-2"
                        class="me-3 rounded-pill bg-white w-fit-content px-5 text-uppercase btn-theme-outline step-trigger"
                      >
                        Skip
                      </button>
                      <button
                        type="button"
                        data-id="slide-2"
                        class="rounded-pill border-0 px-5 w-fit-content text-white px-5 btn-theme-outline border-0 bg-red step-trigger"
                      >
                        Next
                      </button>
                    </div>
                    <ul
                      class="list-unstyled slide-elipsis list-inline text-center mt-4 mb-0"
                    >
                      <li class="list-inline-item">
                        <button type="button" data-id="slide-1" class="active"></button>
                      </li>
                      <li class="list-inline-item">
                        <button type="button" data-id="slide-2"></button>
                      </li>
                      <li class="list-inline-item">
                        <button
                          type="button"
                          
                          data-id="slide-3"
                        ></button>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="slide-box bg-white overflow-hidden d-none" id="slide-2">
          <div class="row">
            <div class="col-lg-6 pe-0">
              <div class="ps-3 pe-1 pt-5 pb-4 slide-box-top-content">
                <h2 class="d-flex align-items-center">
                  <span>What’s the</span>
                  <img src="../assets/images/slide-logo.png" alt="slide logo" />
                </h2>
                <p>
                  The <b>Spark’dLens</b> is a way of seeing your work experience
                  so that you can take informed action in support of your work
                  fulfillment. We all want a meaningful work experience and we
                  all want to make a difference in some way. The
                  <b>Spark’dLens</b> helps you see what’s most important to you
                  and helps you identify actions that will give you the signals
                  of progress you most desire.
                </p>
                <img
                  src="../assets/images/dots.svg"
                  alt="dots"
                  width="100%"
                  class="mt-5"
                />
              </div>
            </div>
            <div class="col-lg-6">
              <div
                class="px-3 py-4 h-100 position-relative bitmap-side"
                style="
                  background: url(../assets/images/Bitmap2.png) no-repeat;
                  background-size: cover;
                  background-position: center;
                "
              >
                <div
                  class="text-white position-relative h-100 d-flex flex-column justify-content-between"
                >
                  <div class="top-slide-content text-white">
                    <h5>About the Spark’dLens</h5>
                    <p>
                      It’s about FOCUSING on what’s meaningful and FRAMING for
                      progress!
                    </p>
                  </div>
                  <div>
                    <div class="d-flex flex-wrap justify-content-center">
                      <button
                        type="button"
                        data-id="slide-3"
                        class="me-3 rounded-pill bg-white w-fit-content px-5 text-uppercase btn-theme-outline step-trigger"
                      >
                        Skip
                      </button>
                      <button
                        type="button"
                        data-id="slide-3"
                        class="rounded-pill border-0 px-5 w-fit-content text-white px-5 btn-theme-outline border-0 bg-red step-trigger"
                      >
                        Next
                      </button>
                    </div>
                    <ul
                      class="list-unstyled slide-elipsis list-inline text-center mt-4 mb-0"
                    >
                      <li class="list-inline-item">
                        <button type="button" data-id="slide-1"></button>
                      </li>
                      <li class="list-inline-item">
                        <button type="button" data-id="slide-2"  class="active"></button>
                      </li>
                      <li class="list-inline-item">
                        <button
                          type="button"
                         
                          data-id="slide-3"
                        ></button>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="slide-box bg-white overflow-hidden d-none" id="slide-3">
          <div class="row">
            <div class="col-lg-6 pe-0">
              <div class="ps-3 pe-1 pt-5 pb-4 slide-box-top-content">
                <h2 class="d-flex align-items-center mb-3">
                  <span>My Action Plan</span>
                </h2>
                <p>
                  At <b>Spark’d,</b> we believe in the power of individuals to
                  create an exceptional work experience for themselves and for
                  others around them. By understanding your
                  <b>engagement drivers,</b> you then have the information you
                  need to take action in support of them. You gain the
                  <b>INSIGHT</b> needed to take <b>MEANINGFUL ACTION.</b>
                </p>
                <img
                  src="../assets/images/dots.svg"
                  alt="dots"
                  width="100%"
                  class="mt-5"
                />
              </div>
            </div>
            <div class="col-lg-6">
              <div
                class="px-3 py-4 h-100 position-relative bitmap-side"
                style="
                  background: url(../assets/images/Bitmap3.png) no-repeat;
                  background-size: cover;
                  background-position: center;
                "
              >
                <div
                  class="text-white position-relative h-100 d-flex flex-column justify-content-between"
                >
                  <div class="top-slide-content text-center pt-4 text-white">
                    <h5>My Action Plan</h5>
                    <p class="pt-3">
                      Next you will see your Personalized Dashboard and will be
                      guided through an action planning process so that you can
                      be in control of your own engagement at work.
                    </p>
                  </div>
                  <div>
                    <div class="d-flex flex-wrap justify-content-center">
                      <button
                        type="button"
                        class="me-3 rounded-pill bg-white w-fit-content px-5 text-uppercase btn-theme-outline step-trigger"
                      >
                        Skip
                      </button>
                      <button
                        type="button"
                        class="rounded-pill border-0 px-5 w-fit-content text-white px-5 btn-theme-outline border-0 bg-red step-trigger"
                      >
                        Next
                      </button>
                    </div>
                    <ul
                      class="list-unstyled slide-elipsis list-inline text-center mt-4 mb-0"
                    >
                      <li class="list-inline-item">
                        <button type="button" data-id="slide-1"></button>
                      </li>
                      <li class="list-inline-item">
                        <button type="button" data-id="slide-2"></button>
                      </li>
                      <li class="list-inline-item">
                        <button
                          type="button"
                          class="active"
                          data-id="slide-3"
                        ></button>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="px-custom text-center developer-info">
        Powered By:
        <a href="theappguys.com" class="text-decoration-none">TheAppGuys.com</a>
      </div>
    </section>
    <script>
      $(document).on("click", ".step-trigger", function () {
        if ($(this).attr("data-id")) {
          $(".slide-box.active")
            .next()
            .addClass("active")
            .removeClass("d-none")
            .prev()
            .removeClass("d-none active")
            .addClass("d-none");
        }
      });
      $('.slide-elipsis button').click(function(){
        var id = $(this).attr('data-id');
        $(".slide-box").addClass('d-none');
        $('#'+id).addClass('active').removeClass('d-none');
      })
    </script>
  </body>
</html>
