@extends('layouts.app')

@section('title', 'Home - CrackerTime')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="category-header">Popular Categories</div>
            <div class="row mt-3">
                <div class="col-md-3 mb-3">
                    <div class="card">
                        <img src="{{ asset('images/demo.jpg') }}" class="card-img-top" alt="Demo">
                        <div class="card-body">
                            <h5 class="card-title">Sparklers</h5>
                            <p class="card-text">Standard pack — 10 pcs</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card">
                        <img src="{{ asset('images/demo.jpg') }}" class="card-img-top" alt="Demo">
                        <div class="card-body">
                            <h5 class="card-title">Flower Pots</h5>
                            <p class="card-text">Special edition</p>
                        </div>
                    </div>
                </div>
                <!-- Add more category cards as needed -->
            </div>
        </div>
    </div>
@endsection
