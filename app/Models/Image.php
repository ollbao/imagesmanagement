<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Image extends Model
{
    use Searchable;

    public $asYouType = true;
    protected $fillable = ['tag', 'show_url', 'down_path', 'image_source', 'source_link', 'description'];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'tag' => $this->tag,
        ];
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function downloadhistories(){
        return $this->hasMany(DownloadHistories::class);
    }
}
