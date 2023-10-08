<?php

namespace App\Modules\Blog\Models;

use App\Models\User;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Blog extends Model
{
    use HasFactory, Uuid, Searchable;

    protected $fillable = [
        'uuid',
        'title',
        'blog_body',
        'image',
        'status',
        'user_id'
    ];

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'blog_body' => $this->blog_body,
        ];
    }
}
