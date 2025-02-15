@extends('app')

@section('content')
  <div class="p-4 space-y-4">
    <div>
      <a class="p-1 border bg-fuchsia-400 rounded" href="{{ route('blogs.index') }}">Back</a>
    </div>
    <div class="space-y-4">
      <h1>Create Blog</h1>
      <form class="space-y-4" action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
          <label for="title">Title</label>
          <input type="text" name="title" id="title">
        </div>
        <div>
          <label for="content">Content</label>
          <textarea name="content" id="content"></textarea>
        </div>
        <div>
          <label for="image">Image</label>
          <input type="file" name="image" id="image" accept="image/*">
        </div>
        <div>
          <button class="rounded p-1 border bg-teal-500" type="submit">Create</button>
        </div>
      </form>
    </div>
  </div>
@endsection