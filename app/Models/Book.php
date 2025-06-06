<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Book extends Model
{
    use HasFactory;

    private const REVIEWS_COUNT_BY_MONTH = 2;
    private const REVIEWS_COUNT_BY_SIX_MONTHS = 5;

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function scopeTitle(Builder $query, string $title): Builder|QueryBuilder
    {
        return $query->where('title', 'like', '%' . $title . '%');
    }

    public function scopeWithReviewsCount(Builder $query, ?string $from = null, ?string $to = null): Builder|QueryBuilder
    {
        return $query->withCount(['reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)]);
    }

    public function scopeWithAvgRating(Builder $query, ?string $from = null, ?string $to = null): Builder|QueryBuilder
    {
        return $query->withAvg(['reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)], 'rating');
    }

    public function scopePopular(Builder $query, ?string $from = null, ?string $to = null): Builder|QueryBuilder
    {
        return $query->withReviewsCount($from, $to)
            ->orderBy('reviews_count', 'desc');
    }

    public function scopeHighestRated(Builder $query, ?string $from = null, ?string $to = null): Builder|QueryBuilder
    {
        return $query->withAvgRating($from, $to)
            ->orderBy('reviews_avg_rating', 'desc');
    }

    public function scopeMinReviews(Builder $query, int $minReviews): Builder|QueryBuilder
    {
        return $query->having('reviews_count', '>=', $minReviews);
    }

    public function scopePopularLastMonth(Builder $query): Builder|QueryBuilder
    {
        return $query->popular(now()->subMonth(), now())
            ->highestRated(now()->subMonth(), now())
            ->minReviews(self::REVIEWS_COUNT_BY_MONTH);
    }

    public function scopePopularLastSixMonths(Builder $query): Builder|QueryBuilder
    {
        return $query->popular(now()->subMonth(6), now())
            ->highestRated(now()->subMonth(6), now())
            ->minReviews(self::REVIEWS_COUNT_BY_SIX_MONTHS);
    }

    public function scopeHighestRatedLastMonth(Builder $query): Builder|QueryBuilder
    {
        return $query->highestRated(now()->subMonth(), now())
            ->popular(now()->subMonth(), now())
            ->minReviews(self::REVIEWS_COUNT_BY_MONTH);
    }

    public function scopeHighestRatedLastSixMonths(Builder $query): Builder|QueryBuilder
    {
        return $query->highestRated(now()->subMonth(6), now())
            ->popular(now()->subMonth(6), now())
            ->minReviews(self::REVIEWS_COUNT_BY_SIX_MONTHS);
    }

    protected static function booted()
    {
        static::updated(fn(Book $book) => cache()->forget('book:' . $book->book_id)); // TODO: refactor cache logic
        static::deleted(fn(Book $book) => cache()->forget('book:' . $book->book_id));
    }

    private function dateRangeFilter(Builder $query, ?string $from = null, ?string $to = Null): void
    {
        if ($from && !$to) {
            $query->where('created_at', '>=', $from);
        } elseif (!$from && $to) {
            $query->where('created_at', '<=', $to);
        } elseif ($from && $to) {
            $query->whereBetween('created_at', [$from, $to]);
        }
    }
}
