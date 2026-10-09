<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'thumbnail',
        'status',
        'is_featured',
        'published_at',
        'seo_title',
        'seo_description',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope a query to only include published news accessible to the public.
     * Includes articles with status 'published' where published_at is passed or null,
     * and 'scheduled' articles where the scheduled time has arrived.
     */
    public function scopePublished(Builder $query): Builder
    {
        $now = Carbon::now('Asia/Jakarta');

        return $query->where(function (Builder $sub) use ($now) {
            $sub->where(function (Builder $pub) use ($now) {
                $pub->where('status', 'published')
                    ->where(function (Builder $p) use ($now) {
                        $p->whereNull('published_at')
                          ->orWhere('published_at', '<=', $now);
                    });
            })->orWhere(function (Builder $sch) use ($now) {
                $sch->where('status', 'scheduled')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', $now);
            });
        });
    }

    /**
     * Check if this news item is publicly visible right now.
     */
    public function isPubliclyVisible(): bool
    {
        if ($this->status === 'draft') {
            return false;
        }

        $now = Carbon::now('Asia/Jakarta');

        if ($this->status === 'published') {
            return is_null($this->published_at) || $this->published_at->timezone('Asia/Jakarta')->lte($now);
        }

        if ($this->status === 'scheduled') {
            return !is_null($this->published_at) && $this->published_at->timezone('Asia/Jakarta')->lte($now);
        }

        return false;
    }

    /**
     * Get computed status label in Indonesian.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'published' => 'Terbit',
            'scheduled' => 'Terjadwal',
            default => 'Draft',
        };
    }

    /**
     * Get estimated reading time in minutes.
     */
    public function getReadingTimeAttribute(): int
    {
        $words = str_word_count(strip_tags($this->content ?? ''));
        return max(1, (int) ceil($words / 180));
    }

    /**
     * Resolve full asset URL for thumbnail.
     */
    public function getThumbnailUrlAttribute(): string
    {
        if (empty($this->thumbnail)) {
            return asset('images/slides/slide-1-dapur-imajinasi.svg');
        }

        if (Str::startsWith($this->thumbnail, ['http://', 'https://'])) {
            return $this->thumbnail;
        }

        return asset($this->thumbnail);
    }

    public static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        if (empty($base)) {
            $base = 'berita';
        }

        $slug = $base;
        $counter = 1;

        while (static::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
