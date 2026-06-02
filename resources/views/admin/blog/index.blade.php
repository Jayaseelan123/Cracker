@extends('layouts.admin')

@section('title', 'Blog Posts')
@section('header', 'Blog Posts')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Blog Posts</h2>
            <p class="text-muted mb-0">Static blog articles shown on the public Blog page</p>
        </div>
        <a href="{{ route('blog') }}" target="_blank" class="btn btn-outline-primary px-4">
            <i class="fas fa-external-link-alt me-2"></i>View Live Blog
        </a>
    </div>

    @php
    $posts = [
        ['title' => 'The Science Behind the Sparkle: How Firecrackers Create Light, Sound & Color',
         'category' => 'Science', 'date' => 'Aug 23, 2025', 'views' => 629, 'slug' => 'science-behind-the-sparkle'],
        ['title' => 'Top 10 Eco-Friendly Crackers for a Green Diwali 2025',
         'category' => 'Eco', 'date' => 'Aug 21, 2025', 'views' => 842, 'slug' => 'eco-friendly-crackers-2025'],
        ['title' => 'Ultimate Guide to Cracker Safety: Essential Tips for Family Celebrations',
         'category' => 'Safety', 'date' => 'Aug 21, 2025', 'views' => 855, 'slug' => 'cracker-safety-guide'],
        ['title' => 'The Brilliant History of Firecrackers: From Ancient China to Your Diwali',
         'category' => 'History', 'date' => 'Aug 21, 2025', 'views' => 498, 'slug' => 'history-of-firecrackers'],
        ['title' => '10 Safe & Sparkling Crackers for Kids — 2025 Guide',
         'category' => 'Kids', 'date' => 'Aug 21, 2025', 'views' => 684, 'slug' => 'kid-friendly-crackers-2025'],
        ['title' => 'How to Budget for Diwali Crackers: Celebrate More, Spend Less in 2025',
         'category' => 'Budget Tips', 'date' => 'Aug 21, 2025', 'views' => 456, 'slug' => 'budget-for-diwali-crackers-2025'],
    ];
    @endphp

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#f8fafc;">
                    <tr>
                        <th class="ps-4 py-3 text-muted fw-semibold small">#</th>
                        <th class="py-3 text-muted fw-semibold small">TITLE</th>
                        <th class="py-3 text-muted fw-semibold small">CATEGORY</th>
                        <th class="py-3 text-muted fw-semibold small">DATE</th>
                        <th class="py-3 text-muted fw-semibold small">VIEWS</th>
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
                        <td>
                            <span class="badge rounded-pill px-3 py-2"
                                  style="background:#fff3cd;color:#856404;font-size:0.78rem;">
                                {{ $post['category'] }}
                            </span>
                        </td>
                        <td class="text-muted small">{{ $post['date'] }}</td>
                        <td>
                            <span class="text-muted small"><i class="fas fa-eye me-1"></i>{{ $post['views'] }}</span>
                        </td>
                        <td class="pe-4 text-end">
                            <a href="{{ route('blog') }}#{{ $post['slug'] }}"
                               target="_blank" class="btn btn-sm btn-light border" title="View on Blog">
                                <i class="fas fa-external-link-alt text-primary"></i>
                            </a>
                        </td>
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
