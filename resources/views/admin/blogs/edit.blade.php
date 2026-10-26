@extends('layouts.admin')

@section('title', 'Edit Blog Post')
@section('header', 'Edit Blog Post')

@push('head')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
.blog-form-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); padding: 30px; margin-bottom: 24px; }
.blog-form-card h5 { font-weight: 700; color: #1a1a2e; margin-bottom: 20px; border-bottom: 2px solid #ff6600; padding-bottom: 10px; }
.form-label { font-weight: 600; color: #444; margin-bottom: 6px; }
#quill-editor { height: 350px; border-radius: 0 0 6px 6px; }
.ql-toolbar { border-radius: 6px 6px 0 0; }
.btn-update { background: #ff6600; color: #fff; border: none; padding: 12px 32px; border-radius: 8px; font-weight: 700; font-size: 1rem; transition: background 0.2s; }
.btn-update:hover { background: #cc5500; color: #fff; }
.btn-view { background: #0d6efd; color: #fff; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; transition: background 0.2s; text-decoration: none; display: inline-flex; align-items: center; }
.btn-view:hover { background: #0b5ed7; color: #fff; }
.btn-cancel { background: #f0f0f0; color: #555; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; transition: background 0.2s; text-decoration: none; display: inline-flex; align-items: center; }
.btn-cancel:hover { background: #ddd; }
.sidebar-stats { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); padding: 25px; position: sticky; top: 80px; }
.sidebar-stats h5 { font-weight: 700; color: #1a1a2e; margin-bottom: 16px; border-bottom: 2px solid #ff6600; padding-bottom: 10px; }
.stat-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f0f0f0; font-size: 0.9rem; }
.stat-row:last-child { border-bottom: none; }
.stat-label { color: #888; }
.stat-value { font-weight: 600; color: #1a1a2e; }
</style>
@endpush

@section('content')
<div class="container-fluid">

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><i class="fas fa-exclamation-triangle me-2"></i>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data" id="blog-form">
        @csrf
        @method('PUT')

        <div class="row">
            {{-- LEFT: Main Form --}}
            <div class="col-lg-8">

                {{-- Title & Category --}}
                <div class="blog-form-card">
                    <h5><i class="fas fa-pen me-2"></i>Post Details</h5>

                    <div class="mb-4">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg @error('title') is-invalid @enderror"
                               id="title" name="title" value="{{ old('title', $blog->title) }}"
                               placeholder="Enter a compelling blog title..." required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                   
                    <div class="mb-3">
                        <label for="published_at" class="form-label">Publish Date</label>
                        <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                               id="published_at" name="published_at"
                               value="{{ old('published_at', $blog->published_at ? $blog->published_at->format('Y-m-d\TH:i') : '') }}">
                        @error('published_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                </div>

                {{-- Content Editor --}}
                <div class="blog-form-card">
                    <h5><i class="fas fa-align-left me-2"></i>Content <span class="text-danger">*</span></h5>

                    {{-- Hidden textarea synced from Quill (no required — JS validates) --}}
                    <textarea id="content" name="content" style="display:none;">{{ old('content', $blog->content) }}</textarea>

                    {{-- Quill editor container --}}
                    <div id="quill-editor"></div>

                    @error('content')
                    <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                {{-- Featured Image --}}
                <div class="blog-form-card">
                    <h5><i class="fas fa-image me-2"></i>Featured Image</h5>

                    @if($blog->image)
                    <div class="mb-3">
                        <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}"
                             style="max-width: 220px; border-radius: 8px; border: 1px solid #eee;">
                        <p class="small text-muted mt-2"><i class="fas fa-info-circle me-1"></i>Current image — upload a new one to replace it</p>
                    </div>
                    @endif

                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                           id="image" name="image" accept="image/*" onchange="previewImage(this)">
                    <small class="text-muted">JPG, PNG, GIF — Max 2MB. Leave empty to keep current image.</small>
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <img id="img-preview" src="#" alt="New image preview"
                         style="max-width: 200px; border-radius: 8px; margin-top: 10px; display: none;">
                </div>

                {{-- Publish Control --}}
                <div class="blog-form-card">
                    <h5><i class="fas fa-toggle-on me-2"></i>Publishing</h5>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                               id="is_published" name="is_published" value="1"
                               {{ old('is_published', $blog->is_published) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="is_published">
                            Published (visible on website)
                        </label>
                    </div>
                    <small class="text-muted d-block mt-1">Uncheck to revert to Draft.</small>
                </div>

                {{-- Submit Buttons --}}
                <div class="d-flex gap-3 mb-4 flex-wrap">
                    <button type="submit" class="btn-update">
                        <i class="fas fa-save me-2"></i>Update Post
                    </button>
                    <a href="{{ route('admin.blogs.show', $blog) }}" class="btn-view">
                        <i class="fas fa-eye me-2"></i>Preview
                    </a>
                    <a href="{{ route('admin.blogs.index') }}" class="btn-cancel">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                </div>

            </div>

            {{-- RIGHT: Stats --}}
            
        </div>
    </form>
</div>

<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
// Initialize Quill editor
var quill = new Quill('#quill-editor', {
    theme: 'snow',
    placeholder: 'Write your blog post content here...',
    modules: {
        toolbar: [
            [{ 'header': [2, 3, 4, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            [{ 'indent': '-1' }, { 'indent': '+1' }],
            ['blockquote', 'code-block'],
            ['link', 'image'],
            ['clean']
        ]
    }
});

// Load existing content into Quill
var existingContent = document.getElementById('content').value;
if (existingContent) {
    quill.clipboard.dangerouslyPasteHTML(existingContent);
}

// Sync content FIRST, then validate
document.getElementById('blog-form').addEventListener('submit', function(e) {
    // Always sync Quill → hidden textarea
    document.getElementById('content').value = quill.root.innerHTML;

    // Validate content not empty
    if (quill.getText().trim().length === 0) {
        e.preventDefault();
        quill.root.style.border = '2px solid #dc3545';
        quill.root.scrollIntoView({ behavior: 'smooth' });
        alert('Please write some content for the blog post.');
        return;
    }
});

// Image preview
function previewImage(input) {
    var preview = document.getElementById('img-preview');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
