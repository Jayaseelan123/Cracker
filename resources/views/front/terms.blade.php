@extends('layouts.app')

@section('title', 'Terms and Conditions')
@section('hero_title', 'Terms and Conditions')
@section('hero_subtitle', 'Please read these terms carefully before using our website')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4 p-md-5">

                    <h2 class="mb-4 text-primary fw-bold border-bottom pb-3">Terms and Conditions</h2>

                    <div class="terms-content" style="line-height: 1.9; color: #444; font-size: 15px;">
                        @if(isset($sections) && $sections->count() > 0)
                            @foreach($sections as $index => $section)
                                <h4 class="text-dark fw-semibold mt-4 mb-3">
                                    {{ $index + 1 }}. {{ $section->title_en }}
                                    @if($section->title_ta)
                                        <br><small class="text-muted" style="font-size: 0.85em;">{{ $section->title_ta }}</small>
                                    @endif
                                </h4>
                                <div>{!! $section->content_en !!}</div>
                                @if($section->content_ta)
                                    <div class="mt-2 pt-2 border-top" style="opacity: 0.9;">{!! $section->content_ta !!}</div>
                                @endif
                            @endforeach
                        @else
                            <p class="text-muted">Terms and conditions will be updated soon.</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
