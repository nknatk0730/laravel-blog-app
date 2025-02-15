@extends('app')

@section('content')
    <div class="p-4 space-y-4">
      <a class="p-1 border rounded hover:bg-blue-400" href="{{ route('blogs.create') }}">Post</a>
      {{ $blogs->links() }}
      {{-- 新規投稿が成功したらフラッシュメッセージ表示 --}}
      @if (session('success'))
        <div class="p-2 text-white bg-green-500">{{ session('success') }}</div>
      @endif
    </div>
    {{-- blogの展開 --}}
    @foreach ($blogs as $blog)
      <div>
        <div class="p-4 border rounded">
          <div class="text-lg">{{ $blog->title }}</div>
          <div class="text-sm">{{ $blog->user->name }}</div>
          <div class="text-sm">{{ $blog->content }}</div>
          <div class="text-sm">{{ $blog->created_at }}</div>
          {{-- image --}}
          @if ($blog->image)
            <img class="w-1/4" src="{{ asset('storage/' . $blog->image) }}" alt="blog image">
          @endif
          @if (Auth::id() === $blog->user_id)
          <div class="mt-2 space-y-2">
            <a class="border p-1 rounded" href="{{ route('blogs.edit', [$blog->id]) }}">Edit</a>
            <form action="{{ route('blogs.destroy', [$blog->id]) }}" method="post">
              @csrf
              @method('DELETE')
              <button class="border p-1 rounded" type="submit">Delete</button>
            </form>
          </div>
          @endif
      </div>
    @endforeach
    <p>User Name: {{ $authUser }}</p>
@endsection