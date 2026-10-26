@extends('layouts.admin')

@section('title', $blog->title . ' - View')
@section('header', 'View Blog Post')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 col-md-6">
            <h1>{{ $blog->title }}</h1>
            <p class="text-muted mb-0">
                <i class="fas fa-calendar-alt"></i> {{ $blog->getFormattedDate() }} |
               
                <span class="badge {{ $blog->is_published ? 'bg-success' : 'bg-warning' }}">{{ $blog->is_published ? 'Published' : 'Draft' }}</span>
            </p>
        </div>
        <div class="col-12 col-md-6 text-md-end mt-3 mt-md-0">
            <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-info" target="_blank">
                <i class="fas fa-external-link-alt"></i> View on Site
            </a>
            <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger delete-btn">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                @if($blog->image)
                <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="card-img-top" style="max-height:400px; object-fit:cover;">
                @endif
                <div class="card-body">
                    <h5 class="card-title">Content</h5>
                    <div style="line-height:1.8; color:#333;">
                        {!! $blog->content !!}
                    </div>
                </div>
            </div>
        </div>

        
    </div>
</div>
@endsection
