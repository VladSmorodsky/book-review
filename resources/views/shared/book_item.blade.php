<div class="book-item">
    <div
        class="flex flex-wrap items-center justify-between">
        <div class="w-full flex-grow sm:w-auto">
            <a href="{{ route('books.show', $book) }}" class="book-title">{{ $book->title }}</a>
            <span class="book-author">by {{ $book->author }}</span>
        </div>
        <div>
            <div class="book-rating">
                <x-star-rating :rating="$book->reviews_avg_rating" />
            </div>
            <div class="book-review-count">
                out of {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}
            </div>
        </div>
    </div>
</div>
