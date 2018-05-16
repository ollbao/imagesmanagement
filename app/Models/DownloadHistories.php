<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DownloadHistories extends Model
{
    protected $fillable = ['scenes', 'url', 'description'];

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
