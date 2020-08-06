<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @property int id
 * @property string title
 * @property string text
 * @property string datetime
 * @property string source_id
 * @property string source_url
 * @property bool has_image
 */
class Article extends Model
{
    protected $fillable = [
        'title',
        'text',
        'datetime',
        'has_image',
        'source_id',
        'source_url',
    ];

    protected $dates = [
        'datetime',
    ];

    public static function fetchExistingSourceIds(array $sourceIds): array
    {
        $sourceIds = self::whereIn('source_id', $sourceIds)->pluck('source_id')->toArray();

        return $sourceIds;
    }

    public function link()
    {
        return route('article', ['id' => $this->id]);
    }

    public function getImagePath()
    {
        return "images/{$this->id}.jpg";
    }

    public function getImageUrl()
    {
        return Storage::url($this->getImagePath());
    }

    public function getShortenedText()
    {
        $stripped = trim(preg_replace('#<[^>]+>#', ' ', $this->text));
        return Str::limit($stripped, 200);
    }

    public function getShortenedSourceUrl()
    {
        $stripped = trim(preg_replace('#https?://#i', '', $this->source_url));
        return Str::limit($stripped, 20);
    }

    public function getReadableDateTime()
    {
        if ($this->datetime->isToday()) {
            $date = 'Сегодня';
        } elseif ($this->datetime->isYesterday()) {
            $date = 'Вчера';
        } else {
            $date = $this->datetime->format('d.m.Y');
        }

        return $date . ' в ' . $this->datetime->format('H:i');
    }
}
