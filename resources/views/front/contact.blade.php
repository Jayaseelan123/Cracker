@extends('layouts.front')

@section('title', 'Contact Us')
@section('hero_title', 'Contact Crackers Time')
@section('hero_subtitle', 'We are here to help')

@section('content')
<div class="row">
    {{-- LEFT SIDE – FORM --}}
    <div class="col-12 col-md-7">
        <div class="card mb-4">
            <div class="quantity-header">
                <h3>Send us a Message</h3>
            </div>
            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="post" action="{{ route('contact.send') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Your Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" 
                               class="form-control @error('name') is-invalid @enderror">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address *</label>
                        <input type="email" name="email" value="{{ old('email') }}" 
                               class="form-control @error('email') is-invalid @enderror">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Message *</label>
                        <textarea name="message" rows="5"
                                  class="form-control @error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                        @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button class="btn btn-primary">Send Message</button>
                </form>

            </div>
        </div>
    </div>

    {{-- RIGHT SIDE – CONTACT INFO --}}
    <div class="col-12 col-md-5">
        <div class="card mb-4">
            <div class="quantity-header">
                <h3>Contact Information</h3>
            </div>
            <div class="card-body">

                <p><strong>Phone</strong><br><a href="tel:+919488864547">+91 9488864547</a></p>

                <p><strong>Email</strong><br><a href="mailto:crackerstime.com@gmail.com">crackerstime.com@gmail.com</a></p>

                <p><strong>Address</strong><br>
                    Door No 2/554/C3 <br>
                    Southside school Near Sivakasi to Sattur main road<br>
                    Mettamalai, Sivakasi - 626203
                </p>

                <p><strong>Business Hours</strong><br>
                    Mon - Sat: 9:00 AM - 8:00 PM<br>
                    Sunday: 10:00 AM - 6:00 PM
                </p>

                <div class="d-flex gap-2 mt-3">
                    <a href="tel:+919488864547" class="btn btn-outline-primary">Call Now</a>
                    <a href="https://wa.me/919488864547" target="_blank" class="btn btn-success">WhatsApp</a>
                </div>

                <div class="mt-4 alert alert-info">
                    <strong>Need Immediate Help?</strong>
                    <p>Call or WhatsApp us for immediate assistance with your orders.</p>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
