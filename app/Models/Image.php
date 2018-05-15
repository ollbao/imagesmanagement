<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['tag', 'show_url', 'down_path', 'image_source', 'source_link', 'description'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
