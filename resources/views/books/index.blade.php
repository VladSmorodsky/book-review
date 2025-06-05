@extends('layouts/app')

@section('content')
    <h1 class="mb-10 text-2xl">Books</h1>
    @include('shared.book_search_form')

    <div class="filter-container mb-4 flex">
        @include('shared.filters')
    </div>

    <ul>
        @forelse ($books as $book)
            <li class="mb-4">
                @include('shared.book_item', ['book' => $book])
            </li>
        @empty
            <li class="mb-4">
                <div class="empty-book-item">
                    <p class="empty-text">No books found</p>
                    <a href="{{ route('books.index') }}" class="reset-link">Reset criteria</a>
                </div>
            </li>
        @endforelse

        @if($books->count())
            <div>
                {{ $books->links() }}
            </div>
        @endif
    </ul>
@endsection
