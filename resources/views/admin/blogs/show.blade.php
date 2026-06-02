@extends('layouts.admin')

@section('title', $blog->title . ' - View')
@section('header', 'View Blog Post')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h1>{{ $blog->title }}</h1>
            <p class="text-muted mb-0">
                <i class="fas fa-calendar-alt"></i> {{ $blog->getFormattedDate() }} |
                <i class="fas fa-eye"></i> {{ $blog->views }} views |
                <span class="badge {{ $blog->is_published ? 'bg-success' : 'bg-warning' }}">{{ $blog->is_published ? 'Published' : 'Draft' }}</span>
            </p>
        </div>
        <div class="col text-end">
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

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">📋 Post Details</h5>
                    <dl class="row small mb-0">
                        <dt class="col-sm-6">Category:</dt>
                        <dd class="col-sm-6"><span class="badge bg-info">{{ $blog->category }}</span></dd>

                        <dt class="col-sm-6">Views:</dt>
                        <dd class="col-sm-6">{{ $blog->views }}</dd>

                        <dt class="col-sm-6">Status:</dt>
                        <dd class="col-sm-6">
                            @if($blog->is_published)
                            <span class="badge bg-success">Published</span>
                            @else
                            <span class="badge bg-warning">Draft</span>
                            @endif
                        </dd>

                        <dt class="col-sm-6">Created:</dt>
                        <dd class="col-sm-6">{{ $blog->created_at->format('M d, Y H:i') }}</dd>

                        <dt class="col-sm-6">Updated:</dt>
                        <dd class="col-sm-6">{{ $blog->updated_at->format('M d, Y H:i') }}</dd>

                        @if($blog->published_at)
                        <dt class="col-sm-6">Published:</dt>
                        <dd class="col-sm-6">{{ $blog->published_at->format('M d, Y H:i') }}</dd>
                        @endif

                        <dt class="col-sm-6">Reading Time:</dt>
                        <dd class="col-sm-6">{{ $blog->getReadingTime() }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">📝 Excerpt</h5>
                    <p class="small mb-0">{{ $blog->excerpt ?: 'No excerpt provided' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
