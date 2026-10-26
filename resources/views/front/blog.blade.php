@extends('layouts.app')

@section('title', 'Blog - Kasthuripyro')
@section('hero_title', 'Our Blog')
@section('hero_subtitle', 'Tips, Guides & Stories About Crackers & Celebrations')

@section('content')
    <style>
        :root {
            --primary: #ff6600;
            --primary-light: #ff9900;
            --dark: #1a1a2e;
            --light: #f9f9f9;
            --border: #e0e0e0;
        }

        .blog-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .blog-grid {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 40px;
        }

        @media (max-width: 768px) {
            .blog-grid {
                grid-template-columns: 1fr;
            }
        }

        .blog-post {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .blog-post:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .blog-post-img {
            width: 100%;
            height: 240px;
            object-fit: cover;
        }

        .blog-post-content {
            padding: 25px;
        }

        .blog-badge {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            padding: 5px 14px;
            border-radius: 20px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .blog-meta {
            font-size: 0.85rem;
            color: #999;
            margin-bottom: 12px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .blog-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .blog-meta i {
            color: var(--primary);
        }

        .blog-post-title {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .blog-post-excerpt {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .blog-read-time {
            font-size: 0.85rem;
            color: #999;
            margin-bottom: 15px;
        }

        .blog-read-more {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: gap 0.3s;
        }

        .blog-read-more:hover {
            gap: 10px;
            color: #cc5500;
        }

        .blog-sidebar {
            position: sticky;
            top: 100px;
        }

        .sidebar-card {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
        }

        .sidebar-title {
            font-size: 1rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 3px solid var(--primary);
        }

        .popular-post {
            display: flex;
            gap: 15px;
            margin-bottom: 16px;
            align-items: flex-start;
        }

        .popular-num {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            color: #fff;
            font-weight: 800;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .popular-info h5 {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--dark);
            margin: 0 0 4px;
            line-height: 1.3;
        }

        .popular-info small {
            color: #999;
            font-size: 0.8rem;
        }

        .popular-info a {
            text-decoration: none;
            color: inherit;
        }

        .popular-info a:hover {
            color: var(--primary);
        }

        .cat-filter {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .cat-chip {
            display: inline-block;
            background: #f0f4ff;
            color: var(--dark);
            border-radius: 20px;
            padding: 7px 16px;
            font-size: 0.85rem;
            text-decoration: none;
            transition: all 0.3s;
            border: 1px solid transparent;
        }

        .cat-chip:hover {
            background: var(--primary);
            color: #fff;
        }

        .cta-card {
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            color: #fff;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
        }

        .cta-card-icon {
            font-size: 48px;
            margin-bottom: 12px;
        }

        .cta-card h4 {
            font-weight: 800;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .cta-card p {
            font-size: 0.9rem;
            opacity: 0.95;
            margin-bottom: 18px;
        }

        .cta-card .btn {
            background: #fff;
            color: var(--primary);
            font-weight: 700;
            border: none;
            padding: 10px 28px;
            border-radius: 25px;
            text-decoration: none;
            display: inline-block;
            transition: transform 0.2s;
        }

        .cta-card .btn:hover {
            transform: scale(1.05);
        }

        .newsletter-box {
            background: linear-gradient(135deg, var(--dark), #2a2a4e);
            color: #fff;
            border-radius: 12px;
            padding: 28px;
            text-align: center;
        }

        .newsletter-box h5 {
            font-weight: 800;
            margin-bottom: 8px;
        }

        .newsletter-box p {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 16px;
        }

        .newsletter-box input {
            width: 100%;
            padding: 11px 14px;
            border-radius: 6px;
            border: none;
            font-size: 0.9rem;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        .newsletter-box button {
            width: 100%;
            padding: 11px;
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            border: none;
            border-radius: 6px;
            color: #fff;
            font-weight: 700;
            cursor: pointer;
            transition: opacity 0.3s;
        }

        .newsletter-box button:hover {
            opacity: 0.9;
        }

        .tips-box {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .tips-box h5 {
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 16px;
            font-size: 1rem;
        }

        .tips-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .tips-list li {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 10px;
            padding-left: 24px;
            position: relative;
            line-height: 1.5;
        }

        .tips-list li:before {
            content: '✓';
            position: absolute;
            left: 0;
            color: var(--primary);
            font-weight: 800;
        }

        .no-blogs {
            text-align: center;
            padding: 80px 20px;
        }

        .no-blogs-icon {
            font-size: 64px;
            opacity: 0.3;
            margin-bottom: 20px;
        }

        .no-blogs h3 {
            color: var(--dark);
            margin-bottom: 8px;
        }

        .no-blogs p {
            color: #999;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }

        .pagination {
            gap: 8px;
        }

        .pagination .page-link {
            border: 1px solid var(--border);
            color: var(--primary);
            border-radius: 6px;
            padding: 8px 12px;
        }

        .pagination .page-link:hover {
            background: var(--primary);
            color: #fff;
        }

        .pagination .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
        }

        @media (max-width: 768px) {
            .blog-sidebar {
                position: static;
                top: auto;
            }

            .blog-post-title {
                font-size: 1.1rem;
            }

            .blog-container {
                padding: 20px 15px;
            }

            .blog-grid {
                gap: 20px;
            }
        }

        .blog-cards-row {
            display: flex;
            flex-wrap: wrap;
            margin: -15px;
        }

        .blog-card-col {
            width: 33.3333%;
            padding: 15px;
        }

        @media (max-width: 992px) {
            .blog-card-col {
                width: 50%;
            }
        }

        @media (max-width: 768px) {
            .blog-card-col {
                width: 100%;
            }
        }

        .blog-post {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .blog-post-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .blog-full-content {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
            color: #666;
            line-height: 1.8;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="blog-cards-row">
        @foreach($blogs as $blog)
            <div class="blog-card-col">
                <div class="blog-post">

                    @if($blog->image)
                        <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="blog-post-img">
                    @else
                        <div class="blog-post-img"
                            style="background: linear-gradient(135deg, #fff8e1, #fffde7); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-image" style="font-size: 48px; opacity: 0.2;"></i>
                        </div>
                    @endif

                    <div class="blog-post-content">


                        <div class="blog-meta">
                            <span>
                                <i class="fas fa-calendar-alt"></i>
                                {{ $blog->getFormattedDate() }}
                            </span>

                        </div>

                        <h3 class="blog-post-title">{{ $blog->title }}</h3>

                        <p class="blog-post-excerpt">
                            {{ Str::limit($blog->excerpt ?: strip_tags($blog->content), 150) }}
                        </p>
                        <div class="blog-full-content" id="content-{{ $blog->id }}" style="display:none;">
                            <hr>
                            {!! $blog->content !!}
                        </div>

                        <div style="margin-top: auto; text-align: right;">
                            <a href="javascript:void(0);" class="blog-read-more"
                                onclick="toggleBlogContent({{ $blog->id }}, this)">
                                Read More <i class="fas fa-chevron-down"></i>
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        @endforeach
    </div>
    <script>
        function toggleBlogContent(id, btn) {
            let content = document.getElementById('content-' + id);

            if (content.style.display === 'none' || content.style.display === '') {
                content.style.display = 'block';
                btn.innerHTML = 'Read Less <i class="fas fa-chevron-up"></i>';
            } else {
                content.style.display = 'none';
                btn.innerHTML = 'Read More <i class="fas fa-chevron-down"></i>';
            }
        }
    </script>

@endsection