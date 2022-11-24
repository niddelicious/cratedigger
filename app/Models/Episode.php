<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'genre', 'style', 'date', 'imageFilename', 'youtubeId', 'twitchId', 'twitchSafe', 'featured', 'redditId', 'mp3Filename'
    ];

    protected $casts = [
        'twitchSafe' => 'boolean',
    ];

    public $timestamps = false;

    
    /**
     * Interact with the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
     protected function twitchTooOld(): Attribute
    {
        if(strtotime($this->date) < strtotime('-6 weeks')) {
            return Attribute::make(
                get: fn ($value) => TRUE,
            );
        } else {
            return Attribute::make(
                get: fn ($value) => FALSE,
            );
        }
    }
}
