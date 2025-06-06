@php
    $filters = [
        '' => 'Latest',
        'popular_last_month' => 'Popular Last Month',
        'popular_last_six_months' => 'Popular Last 6 Month',
        'highest_rated_last_month' => 'Highest Rated Last Month',
        'highest_rated_last_six_months' => 'Highest Rated Last 6 Month',
    ];
@endphp

@foreach($filters as $key => $label)
    <a href="{{ route('books.index', [...request()->query(), 'filter' => $key]) }}"
       class="{{ request('filter') === $key || (request('filter') === null && $key === '') ? 'filter-item-active' : 'filter-item'}}">
        {{ $label }}
    </a>
@endforeach
