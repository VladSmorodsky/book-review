@extends('layouts/app')

@section('content')
    <h1 class="mb-10 text-2xl">Books</h1>
    <form action=""></form>
    <ul>
        @forelse ($books as $book)
            <li class="mb-4">
                @include('books/book_item', ['book' => $book])
            </li>
        @empty
            <li class="mb-4">
                <div class="empty-book-item">
                    <p class="empty-text">No books found</p>
                    <a href="{{ route('books.index') }}" class="reset-link">Reset criteria</a>
                </div>
            </li>
        @endforelse
    </ul>
@endsection
