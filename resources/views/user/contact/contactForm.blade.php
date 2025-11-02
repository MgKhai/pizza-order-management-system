@extends('user.layouts.master')

@section('css_content')
<style>
    body {
      background: #f1f8fc;
    }
    .contact-form {
      border-radius: 20px;
      padding: 30px;
      background: #fff;
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.05);
    }
    .form-control {
      border-radius: 25px;
      padding: 12px 20px;
    }
    .form-control::placeholder {
      color: #aaa;
    }
    .btn-gradient {
      background: linear-gradient(to right, #81C408, #04c8f3);
      color: white;
      padding: 12px 30px;
      border: none;
      border-radius: 30px;
      font-weight: bold;
    }
    .form-image {
      max-width: 100%;
      height: auto;
    }
    @media (max-width: 767px) {
      .form-container {
        flex-direction: column-reverse;
        text-align: center;
      }
      .form-content {
        margin-top: 30px;
      }
    }
  </style>
@endsection

@section('content')
<section class="py-5">
    <div class="container">
      <h2 class="text-center fw-bold mb-4">HAVE SOME QUESTIONS?</h2>

      <div class="d-flex justify-content-center align-items-center mb-4 text-muted small flex-wrap">
        <p>We're here to help! Fill out the form or reach us via email. Our Customer Care Team is available to help you get the best experience out of Pizza Joint whether you have an issue about your order or looking for helpful tips. </p>
      </div>

      <div class="d-flex form-container align-items-center justify-content-between flex-wrap">
        <!-- Left Image -->
        <div class="col-md-6 text-center">
          <img src="{{asset('/backgroundImage/contact_image.png')}}" alt="Envelope" class="form-image" width="450">
        </div>

        <!-- Right Form -->
        <div class="col-md-6 form-content">
          <form class="contact-form" action="{{ route('user#contact') }}" method="post">
            @csrf
            <div class="mb-3">
              <input type="text" class="form-control" placeholder="Name" value="{{ Auth::user()->name != null ? Auth::user()->name : Auth::user()->nickname }}" disabled>
            </div>
            <div class="mb-3">
              <input type="email" class="form-control" placeholder="Email" value="{{ Auth::user()->email }}" disabled>
            </div>
            <div class="mb-3">
              <input type="text" name="title" class="form-control @error('title')
                  is-invalid
              @enderror " placeholder="What's your title?" value="{{ old('title') }}">
              @error('title')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="mb-3">
              <textarea class="form-control @error('message')
                  is-invalid
              @enderror" name="message" rows="4" placeholder="Your message...">{{ old('message') }}</textarea>
              @error('message')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="text-center">
              <button type="submit" class="btn-gradient w-100">SEND MESSAGE</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
@endsection