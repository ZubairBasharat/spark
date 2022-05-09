@extends('components.app')
@section('content')
<section
  class="main-wrap-auth pb-md-5 pb-3"
  style="
  background: url(../assets/images/contact-layer.png);
  background-repeat: no-repeat;
  background-position: top -65px right;
  "
>
  <div class="auth-content px-custom mb-lg-5 col-lg-8 col-xl-7">
    <h1>Contact Us</h1>
    <h6>We Can’t wait to meet you</h6>
    <form class="auth-form">
      <div class="dataset-field">
        <label>First Name <sub>*</sub></label>
        <input type="text" class="d-block" name="first_name" placeholder="Enter your first name" />
      </div>
      <div class="dataset-field mb-3">
        <label>Last Name <sub>*</sub></label>
        <input type="text" class="d-block" name="last_name" placeholder="Enter your last name" />
      </div>
      <div class="dataset-field mb-3">
        <label>Email <sub>*</sub></label>
        <input type="email" class="d-block" name="email" placeholder="Enter your last name" />
      </div>
      <div class="dataset-field mb-3">
        <label>Your Message <sub>*</sub></label>
        <textarea class="d-block" placeholder="Enter your message here"></textarea>
      </div>
      <div class="dataset-field px-lg-3 mt-5">
        <button type="button" class="w-100 border-0">Send</button>
      </div>
    </form>
  </div>
</section>
<div class="before-layer">
  <img src="{{asset('assets/images/bottom-layer.svg')}}" alt="bottom Layer" class="w-100" />
</div>
@endsection