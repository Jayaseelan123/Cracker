<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'image',
        'category',
        'views',
        'published_at',
        'is_published'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean'
    ];

    /**
     * Get the route key for implicit model binding.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Scope: Get only published posts
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->where('published_at', '<=', now())
                     ->latest('published_at');
    }

    /**
     * Increment views count
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Get formatted date
     */
    public function getFormattedDate()
    {
        return $this->published_at
            ? $this->published_at->format('M d, Y')
            : $this->created_at->format('M d, Y');
    }

    /**
     * Get word count
     */
    public function getReadingTime()
    {
        $words = str_word_count(strip_tags($this->content));
        $minutes = ceil($words / 200); // Assuming 200 words per minute
        return $minutes . ' min read';
    }
}
