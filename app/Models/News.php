<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'category',
        'images',
        'postDate',
        'posted_by',
    ];

    protected $casts = [
        'images' => 'array',
        'category' => 'array',
    ];

    public function postedBy()
    {
        return $this->belongsTo(User::class, 'posted_by', 'username');
    }
}
