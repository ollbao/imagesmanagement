<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use App\Library\JiebaTokenizer;

class Image extends Model
{
    use Searchable;

    public $asYouType = true;
    protected $fillable = ['show_url', 'down_path', 'image_source', 'source_link', 'description'];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $jiebaTokenizer = new JiebaTokenizer();
        $removeSymbol = ["，","。","、","（","）"];
        return [
            'id' => $this->id,
            'description' => implode(',', $jiebaTokenizer->cut(str_replace($removeSymbol, ' ', $this->description))),
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
