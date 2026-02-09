@extends('layouts.front')

@section('title', 'Blog')
@section('hero_title', 'Our Blog')
@section('hero_subtitle', 'Latest news, guides and tips')

@section('content')
<div class="row">
    <div class="col-12 col-md-8">
        @foreach($posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted small">{{ $post['date'] }} • {{ $post['views'] }} views</div>
                            <h5 class="mt-2">{{ $post['title'] }}</h5>
                            <p class="text-muted">{{ $post['excerpt'] }}</p>
                            <a href="#" class="btn btn-link">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="col-12 col-md-4">
        <div class="card mb-3">
            <div class="card-body">
                <h6>Popular Posts</h6>
                <ul class="list-unstyled">
                    @foreach(array_slice($posts, 0, 4) as $p)
                        <li class="mb-2"><a href="#">{{ $p['title'] }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
