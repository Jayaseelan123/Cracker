@extends('layouts.admin')

@section('title', 'Blog Posts')
@section('header', 'Blog Posts')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Blog Posts</h2>
            <p class="text-muted mb-0">Static blog articles shown on the public Blog page</p>
        </div>
        <a href="{{ route('blog') }}" target="_blank" class="btn btn-outline-primary px-4 text-nowrap">
            <i class="fas fa-external-link-alt me-2"></i>View Live Blog
        </a>
    </div>

    @php
   
    @endphp

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#f8fafc;">
                    <tr>
                        <th class="ps-4 py-3 text-muted fw-semibold small">#</th>
                        <th class="py-3 text-muted fw-semibold small">TITLE</th>
                        
                        <th class="py-3 text-muted fw-semibold small">DATE</th>
                        
                        <th class="py-3 text-muted fw-semibold small pe-4 text-end">LINK</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $i => $post)
                    <tr>
                        <td class="ps-4 text-muted">{{ $i + 1 }}</td>
                        <td>
                            <span class="fw-semibold text-dark">{{ $post['title'] }}</span>
                        </td>
                        
                        <td class="text-muted small">{{ $post['date'] }}</td>
                       
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white border-top py-3 px-4 text-muted small">
            <i class="fas fa-info-circle me-1 text-primary"></i>
            Blog posts are currently static. To manage them dynamically, a Blog database model can be added.
        </div>
    </div>

</div>
@endsection
