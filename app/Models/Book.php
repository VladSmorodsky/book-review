<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Book extends Model
{
    use HasFactory;

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function scopeTitle(Builder $query, string $title): Builder
    {
        return $query->where('title', 'like', '%' . $title . '%');
    }

    public function scopePopular(Builder $query, ?string $from = null, ?string $to = null): Builder
    {
        return $query->withCount(['reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)])
            ->orderBy('reviews_count', 'desc');
    }

    public function scopeHighestRated(Builder $query, ?string $from = null, ?string $to = null): Builder
    {
        return $query->withAvg(['reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)], 'rating')
            ->orderBy('reviews_avg_rating', 'desc');
    }

    public function scopeMinReviews(Builder $query, int $minReviews): Builder
    {
        return $query->has('reviews', '>=', $minReviews);
    }

    public function scopeCreatedAt(Builder $query, ?string $from = null, ?string $to = Null): Builder
    {
        return $this->dateRangeFilter($query, $from, $to);
    }

    private function dateRangeFilter(Builder $query, ?string $from = null, ?string $to = Null): Builder
    {
        if ($from && !$to) {
            return $query->where('created_at', '>=', $from);
        } elseif (!$from && $to) {
            return $query->where('created_at', '<=', $to);
        } elseif ($from && $to) {
            return $query->whereBetween('created_at', [$from, $to]);
        }
        return $query;
    }
}
