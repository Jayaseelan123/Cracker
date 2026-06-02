@extends('layouts.app')

@section('title', 'Blog - Crackers Time')
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

.blog-container { max-width: 1200px; margin: 0 auto; padding: 40px 20px; }
.blog-grid { display: grid; grid-template-columns: 1fr 350px; gap: 40px; }
@media (max-width: 768px) { .blog-grid { grid-template-columns: 1fr; } }

.blog-post { background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08); margin-bottom: 30px; transition: transform 0.3s, box-shadow 0.3s; }
.blog-post:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.12); }
.blog-post-img { width: 100%; height: 240px; object-fit: cover; }
.blog-post-content { padding: 25px; }
.blog-badge { display: inline-block; background: linear-gradient(135deg, var(--primary-light), var(--primary)); color: #fff; font-size: 11px; font-weight: 700; padding: 5px 14px; border-radius: 20px; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px; }
.blog-meta { font-size: 0.85rem; color: #999; margin-bottom: 12px; display: flex; gap: 15px; flex-wrap: wrap; }
.blog-meta span { display: flex; align-items: center; gap: 5px; }
.blog-meta i { color: var(--primary); }
.blog-post-title { font-size: 1.2rem; font-weight: 800; color: var(--dark); margin-bottom: 10px; line-height: 1.4; }
.blog-post-excerpt { color: #666; font-size: 0.95rem; line-height: 1.6; margin-bottom: 15px; }
.blog-read-time { font-size: 0.85rem; color: #999; margin-bottom: 15px; }
.blog-read-more { color: var(--primary); font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: gap 0.3s; }
.blog-read-more:hover { gap: 10px; color: #cc5500; }

.blog-sidebar { position: sticky; top: 100px; }
.sidebar-card { background: #fff; border-radius: 12px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); margin-bottom: 25px; }
.sidebar-title { font-size: 1rem; font-weight: 800; color: var(--dark); margin-bottom: 18px; padding-bottom: 12px; border-bottom: 3px solid var(--primary); }
.popular-post { display: flex; gap: 15px; margin-bottom: 16px; align-items: flex-start; }
.popular-num { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, var(--primary-light), var(--primary)); color: #fff; font-weight: 800; font-size: 0.9rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.popular-info h5 { font-size: 0.9rem; font-weight: 700; color: var(--dark); margin: 0 0 4px; line-height: 1.3; }
.popular-info small { color: #999; font-size: 0.8rem; }
.popular-info a { text-decoration: none; color: inherit; }
.popular-info a:hover { color: var(--primary); }

.cat-filter { display: flex; flex-wrap: wrap; gap: 8px; }
.cat-chip { display: inline-block; background: #f0f4ff; color: var(--dark); border-radius: 20px; padding: 7px 16px; font-size: 0.85rem; text-decoration: none; transition: all 0.3s; border: 1px solid transparent; }
.cat-chip:hover { background: var(--primary); color: #fff; }

.cta-card { background: linear-gradient(135deg, var(--primary-light), var(--primary)); color: #fff; border-radius: 12px; padding: 30px; text-align: center; }
.cta-card-icon { font-size: 48px; margin-bottom: 12px; }
.cta-card h4 { font-weight: 800; margin-bottom: 10px; font-size: 1.1rem; }
.cta-card p { font-size: 0.9rem; opacity: 0.95; margin-bottom: 18px; }
.cta-card .btn { background: #fff; color: var(--primary); font-weight: 700; border: none; padding: 10px 28px; border-radius: 25px; text-decoration: none; display: inline-block; transition: transform 0.2s; }
.cta-card .btn:hover { transform: scale(1.05); }

.newsletter-box { background: linear-gradient(135deg, var(--dark), #2a2a4e); color: #fff; border-radius: 12px; padding: 28px; text-align: center; }
.newsletter-box h5 { font-weight: 800; margin-bottom: 8px; }
.newsletter-box p { font-size: 0.9rem; opacity: 0.9; margin-bottom: 16px; }
.newsletter-box input { width: 100%; padding: 11px 14px; border-radius: 6px; border: none; font-size: 0.9rem; margin-bottom: 10px; box-sizing: border-box; }
.newsletter-box button { width: 100%; padding: 11px; background: linear-gradient(135deg, var(--primary-light), var(--primary)); border: none; border-radius: 6px; color: #fff; font-weight: 700; cursor: pointer; transition: opacity 0.3s; }
.newsletter-box button:hover { opacity: 0.9; }

.tips-box { background: #fff; border-radius: 12px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
.tips-box h5 { font-weight: 800; color: var(--dark); margin-bottom: 16px; font-size: 1rem; }
.tips-list { list-style: none; padding: 0; margin: 0; }
.tips-list li { font-size: 0.9rem; color: #666; margin-bottom: 10px; padding-left: 24px; position: relative; line-height: 1.5; }
.tips-list li:before { content: '✓'; position: absolute; left: 0; color: var(--primary); font-weight: 800; }

.no-blogs { text-align: center; padding: 80px 20px; }
.no-blogs-icon { font-size: 64px; opacity: 0.3; margin-bottom: 20px; }
.no-blogs h3 { color: var(--dark); margin-bottom: 8px; }
.no-blogs p { color: #999; }

.pagination-wrapper { display: flex; justify-content: center; margin-top: 50px; }
.pagination { gap: 8px; }
.pagination .page-link { border: 1px solid var(--border); color: var(--primary); border-radius: 6px; padding: 8px 12px; }
.pagination .page-link:hover { background: var(--primary); color: #fff; }
.pagination .page-item.active .page-link { background: var(--primary); border-color: var(--primary); }

@media (max-width: 768px) {
  .blog-sidebar { position: static; top: auto; }
  .blog-post-title { font-size: 1.1rem; }
  .blog-container { padding: 20px 15px; }
  .blog-grid { gap: 20px; }
}
</style>

<div class="blog-container">
  <div class="blog-grid">
    
    <!-- LEFT: Blog Posts -->
    <div>
      @if($blogs->count() > 0)
        @foreach($blogs as $blog)
        <div class="blog-post">
          @if($blog->image)
          <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="blog-post-img">
          @else
          <div class="blog-post-img" style="background: linear-gradient(135deg, #fff8e1, #fffde7); display: flex; align-items: center; justify-content: center;"><i class="fas fa-image" style="font-size: 48px; opacity: 0.2;"></i></div>
          @endif
          <div class="blog-post-content">
            <span class="blog-badge">{{ $blog->category }}</span>
            <div class="blog-meta">
              <span><i class="fas fa-calendar-alt"></i> {{ $blog->getFormattedDate() }}</span>
              <span><i class="fas fa-eye"></i> {{ $blog->views }} views</span>
            </div>
            <h3 class="blog-post-title">{{ $blog->title }}</h3>
            <p class="blog-post-excerpt">{{ Str::limit($blog->excerpt ?: strip_tags($blog->content), 150) }}</p>
            <div class="blog-read-time"><i class="fas fa-hourglass-half"></i> {{ $blog->getReadingTime() }}</div>

          </div>
        </div>
        @endforeach

        <div class="pagination-wrapper">
          {{ $blogs->links('pagination::bootstrap-4') }}
        </div>
      @else
        <div class="no-blogs">
          <div class="no-blogs-icon"><i class="fas fa-inbox"></i></div>
          <h3>No Blog Posts Yet</h3>
          <p>Check back soon for tips and stories!</p>
        </div>
      @endif
    </div>

    <!-- RIGHT: Sidebar -->
    <div class="blog-sidebar">
      
      <!-- Popular Posts -->
      <div class="sidebar-card">
        <h5 class="sidebar-title"><i class="fas fa-fire"></i> Popular Posts</h5>
        @php $popular = \App\Models\Blog::published()->orderBy('views', 'desc')->limit(5)->get(); @endphp
        @forelse($popular as $i => $post)
        <div class="popular-post">
          <div class="popular-num">{{ $i + 1 }}</div>
          <div class="popular-info">
            <h5><a href="{{ route('blog.show', $post->slug) }}">{{ Str::limit($post->title, 45) }}</a></h5>
            <small><i class="fas fa-eye"></i> {{ $post->views }} views</small>
          </div>
        </div>
        @empty
        <p style="color: #999; font-size: 0.9rem; margin: 0;">No posts yet</p>
        @endforelse
      </div>

      <!-- Categories -->
      <div class="sidebar-card">
        <h5 class="sidebar-title"><i class="fas fa-tag"></i> Categories</h5>
        <div class="cat-filter">
          @php $categories = \App\Models\Blog::published()->pluck('category')->unique(); @endphp
          @forelse($categories as $cat)
            <a href="{{ route('blog.category', $cat) }}" class="cat-chip">{{ $cat }}</a>
          @empty
            <p style="color: #999; font-size: 0.9rem;">No categories</p>
          @endforelse
        </div>
      </div>

      <!-- CTA Card -->
      <div class="cta-card">
        <div class="cta-card-icon">🎆</div>
        <h4>Ready to Celebrate?</h4>
        <p>Shop premium crackers at the best prices!</p>
        <a href="{{ route('home') }}" class="btn">Shop Now</a>
      </div>

      <!-- Newsletter -->
      <div class="newsletter-box">
        <div style="font-size: 36px; margin-bottom: 10px;">📬</div>
        <h5>Stay Updated!</h5>
        <p>Get the latest tips and offers in your inbox.</p>
        <input type="email" placeholder="Your email">
        <button onclick="this.textContent='✅ Subscribed!'; this.disabled=true;">Subscribe</button>
      </div>

      <!-- Safety Tips -->
      <div class="tips-box">
        <h5><i class="fas fa-shield-alt"></i> Safety Tips</h5>
        <ul class="tips-list">
          <li>Buy from licensed sellers</li>
          <li>Keep water bucket nearby</li>
          <li>Wear cotton clothes</li>
          <li>Never re-light duds</li>
          <li>Keep pets indoors</li>
          <li>Supervise children</li>
        </ul>
      </div>

    </div>

  </div>
</div>

@endsection
