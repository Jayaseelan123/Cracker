@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Edit Category</h2>
    <a href="{{ route('category.index') }}" class="btn btn-outline-secondary">Back to list</a>
</div>

<div class="card p-3">
    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('category.update', $category->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Tamil Name (optional)</label>
        <input type="text" name="tamil_name" class="form-control" value="{{ old('tamil_name', $category->tamil_name) }}">
      </div>
      <div class="mb-3">
        <label class="form-label">Slug</label>
        <input type="text" name="slug" class="form-control" value="{{ old('slug', $category->slug) }}" required>
      </div>
      <button class="btn btn-primary" type="submit">Update</button>
    </form>
</div>
@endsection
