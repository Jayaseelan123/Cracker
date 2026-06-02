@extends('layouts.admin')

@section('title', 'Create Blog Post')
@section('header', 'Create Blog Post')

@push('head')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
.blog-form-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); padding: 30px; margin-bottom: 24px; }
.blog-form-card h5 { font-weight: 700; color: #1a1a2e; margin-bottom: 20px; border-bottom: 2px solid #ff6600; padding-bottom: 10px; }
.form-label { font-weight: 600; color: #444; margin-bottom: 6px; }
#quill-editor { height: 350px; border-radius: 0 0 6px 6px; }
.ql-toolbar { border-radius: 6px 6px 0 0; }
.img-preview { max-width: 200px; border-radius: 8px; margin-top: 10px; display: none; }
.tip-list li { font-size: 0.88rem; color: #666; margin-bottom: 8px; }
.btn-create { background: #ff6600; color: #fff; border: none; padding: 12px 32px; border-radius: 8px; font-weight: 700; font-size: 1rem; transition: background 0.2s; }
.btn-create:hover { background: #cc5500; color: #fff; }
.btn-cancel { background: #f0f0f0; color: #555; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; transition: background 0.2s; }
.btn-cancel:hover { background: #ddd; }
.sidebar-info { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); padding: 25px; position: sticky; top: 80px; }
.sidebar-info h5 { font-weight: 700; color: #1a1a2e; margin-bottom: 16px; border-bottom: 2px solid #ff6600; padding-bottom: 10px; }
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

    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" id="blog-form">
        @csrf

        <div class="row">
            {{-- LEFT: Main Form --}}
            <div class="col-lg-8">

                {{-- Title & Category --}}
                <div class="blog-form-card">
                    <h5><i class="fas fa-pen me-2"></i>Post Details</h5>

                    <div class="mb-4">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg @error('title') is-invalid @enderror"
                               id="title" name="title" value="{{ old('title') }}"
                               placeholder="Enter a compelling blog title..." required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                <option value="">Select Category</option>
                                <option value="General"  {{ old('category') === 'General'  ? 'selected' : '' }}>General</option>
                                <option value="Science"  {{ old('category') === 'Science'  ? 'selected' : '' }}>Science</option>
                                <option value="Eco"      {{ old('category') === 'Eco'      ? 'selected' : '' }}>Eco / Green</option>
                                <option value="Safety"   {{ old('category') === 'Safety'   ? 'selected' : '' }}>Safety</option>
                                <option value="History"  {{ old('category') === 'History'  ? 'selected' : '' }}>History</option>
                                <option value="Kids"     {{ old('category') === 'Kids'     ? 'selected' : '' }}>Kids</option>
                                <option value="Budget"   {{ old('category') === 'Budget'   ? 'selected' : '' }}>Budget Tips</option>
                            </select>
                            @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="published_at" class="form-label">Publish Date</label>
                            <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                                   id="published_at" name="published_at" value="{{ old('published_at') }}">
                            <small class="text-muted">Leave empty to use current time when publishing</small>
                            @error('published_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Excerpt <small class="text-muted fw-normal">(Short summary shown in listing)</small></label>
                        <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                  id="excerpt" name="excerpt" rows="2" maxlength="500"
                                  placeholder="Write a short 1-2 sentence summary...">{{ old('excerpt') }}</textarea>
                        <small class="text-muted">Max 500 characters. Auto-generated from content if left empty.</small>
                        @error('excerpt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Content Editor --}}
                <div class="blog-form-card">
                    <h5><i class="fas fa-align-left me-2"></i>Content <span class="text-danger">*</span></h5>

                    {{-- Hidden textarea synced from Quill (no required — JS validates) --}}
                    <textarea id="content" name="content" style="display:none;">{{ old('content') }}</textarea>

                    {{-- Quill editor container --}}
                    <div id="quill-editor"></div>

                    @error('content')
                    <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                {{-- Featured Image --}}
                <div class="blog-form-card">
                    <h5><i class="fas fa-image me-2"></i>Featured Image</h5>
                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                           id="image" name="image" accept="image/*" onchange="previewImage(this)">
                    <small class="text-muted">JPG, PNG, GIF — Max 2MB. Recommended size: 1200×630px.</small>
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <img id="img-preview" class="img-preview" src="#" alt="Preview">
                </div>

                {{-- Publish Control --}}
                <div class="blog-form-card">
                    <h5><i class="fas fa-toggle-on me-2"></i>Publishing</h5>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                               id="is_published" name="is_published" value="1"
                               {{ old('is_published') ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="is_published">
                            Publish this post immediately
                        </label>
                    </div>
                    <small class="text-muted d-block mt-1">When unchecked, post is saved as <strong>Draft</strong> and not visible on the website.</small>
                </div>

                {{-- Submit Buttons --}}
                <div class="d-flex gap-3 mb-4">
                    <button type="submit" class="btn-create" id="submit-btn">
                        <i class="fas fa-save me-2"></i>Create Post
                    </button>
                    <a href="{{ route('admin.blogs.index') }}" class="btn-cancel text-decoration-none d-inline-flex align-items-center">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                </div>

            </div>

            {{-- RIGHT: Sidebar Tips --}}
            <div class="col-lg-4">
                <div class="sidebar-info">
                    <h5><i class="fas fa-lightbulb me-2"></i>Writing Tips</h5>
                    <ul class="tip-list">
                        <li>✅ Use a clear, descriptive title (50–60 chars)</li>
                        <li>✅ Add an excerpt for the listing preview</li>
                        <li>✅ Upload a high-quality featured image</li>
                        <li>✅ Break content with headings (H2, H3)</li>
                        <li>✅ Use bullet lists to improve readability</li>
                        <li>✅ Aim for 400–800 words per post</li>
                        <li>✅ Choose the right category for visibility</li>
                        <li>✅ Toggle "Publish" when ready to go live</li>
                    </ul>
                </div>
            </div>
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

// Restore old() content if validation failed and page reloaded
var existingContent = document.getElementById('content').value;
if (existingContent.trim()) {
    quill.clipboard.dangerouslyPasteHTML(existingContent);
}

// Sync content FIRST, then validate — before browser can block
document.getElementById('blog-form').addEventListener('submit', function(e) {
    // Always sync Quill → hidden textarea
    document.getElementById('content').value = quill.root.innerHTML;

    // Validate that content is not empty
    if (quill.getText().trim().length === 0) {
        e.preventDefault();
        quill.root.style.border = '2px solid #dc3545';
        quill.root.scrollIntoView({ behavior: 'smooth' });
        alert('Please write some content for the blog post.');
        return;
    }

    // Visual feedback: disable button to prevent double submit
    var btn = document.getElementById('submit-btn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating...';
});

// Image preview on file select
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
