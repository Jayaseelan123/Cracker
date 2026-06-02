@extends('layouts.app')

@section('title', $blog->title . ' - Blog - Crackers Time')
@section('hero_title', $blog->title)
@section('hero_subtitle', $blog->published_at ? $blog->published_at->format('M d, Y') : $blog->created_at->format('M d, Y'))

@section('content')
<style>
.blog-single-container{max-width:900px;margin:0 auto}
.blog-header{background:#fff;border-radius:16px;padding:40px;box-shadow:0 6px 25px rgba(0,0,0,.07);margin-bottom:40px}
.blog-meta-info{display:flex;gap:20px;font-size:0.95rem;color:#666;margin-bottom:20px;flex-wrap:wrap}
.blog-meta-item{display:flex;align-items:center;gap:8px}
.blog-meta-item i{color:#ff6600;font-size:1.1rem}
.blog-category-badge{display:inline-block;background:linear-gradient(135deg,#ff9900,#ff6600);color:#fff;padding:6px 16px;border-radius:30px;font-size:0.85rem;font-weight:700;margin-bottom:20px}
.blog-content{background:#fff;border-radius:16px;padding:40px;box-shadow:0 6px 25px rgba(0,0,0,.07);margin-bottom:40px;line-height:1.9;color:#333}
.blog-content h2{font-size:1.8rem;font-weight:800;color:#1a1a2e;margin-top:30px;margin-bottom:15px}
.blog-content h3{font-size:1.4rem;font-weight:700;color:#1a1a2e;margin-top:25px;margin-bottom:12px}
.blog-content h4{font-size:1.1rem;font-weight:700;color:#1a1a2e;margin-top:20px;margin-bottom:10px}
.blog-content p{margin-bottom:15px;text-align:justify}
.blog-content ul{margin-left:20px;margin-bottom:15px}
.blog-content ul li{margin-bottom:10px}
.blog-content ol{margin-left:20px;margin-bottom:15px}
.blog-content ol li{margin-bottom:10px}
.blog-content img{max-width:100%;height:auto;border-radius:12px;margin:20px 0}
.tip-box{background:linear-gradient(135deg,#fff8e1,#fffde7);border-left:4px solid #ff9900;border-radius:8px;padding:20px;margin:20px 0}
.tip-box p{margin:0;color:#555}
.blog-navigation{display:flex;justify-content:space-between;gap:20px;margin-bottom:40px;flex-wrap:wrap}
.blog-nav-card{flex:1;min-width:200px;background:#fff;border-radius:12px;padding:20px;box-shadow:0 4px 15px rgba(0,0,0,.07);text-decoration:none;transition:transform .3s}
.blog-nav-card:hover{transform:translateY(-3px);box-shadow:0 8px 25px rgba(0,0,0,.12)}
.blog-nav-card small{color:#999;font-size:0.85rem}
.blog-nav-card h5{color:#1a1a2e;font-weight:700;margin:10px 0;line-height:1.3}
.blog-nav-card.prev::before{content:'← Previous';display:block;color:#ff6600;font-weight:700;font-size:0.85rem;margin-bottom:8px}
.blog-nav-card.next{text-align:right}.blog-nav-card.next::after{content:'Next →';display:block;color:#ff6600;font-weight:700;font-size:0.85rem;margin-top:8px}
.related-posts{background:#fff;border-radius:16px;padding:30px;box-shadow:0 6px 25px rgba(0,0,0,.07);margin-bottom:40px}
.related-posts h3{font-size:1.3rem;font-weight:800;color:#1a1a2e;margin-bottom:25px}
.related-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:20px}
.related-card{background:#f9f9f9;border-radius:12px;overflow:hidden;transition:transform .3s,box-shadow .3s;text-decoration:none;display:block;color:inherit}
.related-card:hover{transform:translateY(-5px);box-shadow:0 8px 20px rgba(0,0,0,.1)}
.related-card-img{width:100%;height:180px;object-fit:cover}
.related-card-body{padding:16px}
.related-card-body h5{font-size:0.95rem;font-weight:700;color:#1a1a2e;margin-bottom:8px;line-height:1.3}
.related-card-body p{font-size:0.85rem;color:#666;margin:0}
.share-buttons{display:flex;gap:12px;margin-top:15px}
.share-btn{display:inline-flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:50%;background:#f0f0f0;color:#333;text-decoration:none;transition:background .2s}
.share-btn:hover{background:#ff6600;color:#fff}
.toc{background:#f0f7ff;border-left:4px solid #ff6600;border-radius:8px;padding:20px;margin:20px 0}
.toc h4{margin-top:0;font-size:1rem}
.toc ul{margin-bottom:0}
.toc a{color:#ff6600;text-decoration:none}
.toc a:hover{text-decoration:underline}
</style>

<div class="blog-single-container">

    <!-- Blog Header -->
    <div class="blog-header">
        @if($blog->image)
        <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" style="width:100%; height:400px; object-fit:cover; border-radius:12px; margin-bottom:30px;">
        @endif
        
        <span class="blog-category-badge">{{ $blog->category }}</span>
        
        <div class="blog-meta-info">
            <div class="blog-meta-item">
                <i class="fas fa-calendar-alt"></i>
                <span>{{ $blog->getFormattedDate() }}</span>
            </div>
            <div class="blog-meta-item">
                <i class="fas fa-eye"></i>
                <span>{{ $blog->views }} views</span>
            </div>
            <div class="blog-meta-item">
                <i class="fas fa-hourglass-half"></i>
                <span>{{ $blog->getReadingTime() }}</span>
            </div>
        </div>
    </div>

    <!-- Blog Content -->
    <div class="blog-content">
        {!! $blog->content !!}

        <hr style="margin:40px 0; border:none; border-top:2px solid #f0f0f0;">

        <!-- Share Buttons -->
        <div style="margin-top:30px;">
            <h4 style="margin-top:0;">Share This Post:</h4>
            <div class="share-buttons">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $blog->slug)) }}" class="share-btn" title="Share on Facebook" target="_blank">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $blog->slug)) }}&text={{ urlencode($blog->title) }}" class="share-btn" title="Share on Twitter" target="_blank">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('blog.show', $blog->slug)) }}" class="share-btn" title="Share on LinkedIn" target="_blank">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="https://api.whatsapp.com/send?text={{ urlencode($blog->title . ' ' . route('blog.show', $blog->slug)) }}" class="share-btn" title="Share on WhatsApp" target="_blank">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Related Posts -->
    @if($relatedPosts->count() > 0)
    <div class="related-posts">
        <h3>Related Articles</h3>
        <div class="related-grid">
            @foreach($relatedPosts as $post)
            <a href="{{ route('blog.show', $post->slug) }}" class="related-card">
                @if($post->image)
                <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" class="related-card-img">
                @endif
                <div class="related-card-body">
                    <h5>{{ Str::limit($post->title, 50) }}</h5>
                    <p>{{ $post->getFormattedDate() }} • {{ $post->getReadingTime() }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Back Button -->
    <div style="text-align:center; margin:40px 0;">
        <a href="{{ route('blog') }}" class="btn btn-outline-primary btn-lg" style="border-color:#ff6600; color:#ff6600; padding:12px 40px; border-radius:50px; font-weight:700;">
            <i class="fas fa-arrow-left"></i> Back to Blog
        </a>
    </div>

</div>

<script>
// Increment views after page load
document.addEventListener('DOMContentLoaded', function() {
    // Views are already incremented in controller
});
</script>
@endsection
