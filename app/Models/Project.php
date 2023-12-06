<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    public function Type()
    {
        return $this->belongsTo(Type::class);
    }

    public function Technologies()
    {
        return $this->belongsToMany(Technology::class);
    }

    protected $fillable = [
        'type_id',
        'name',
        'slug',
        'description',
        'image',
        'image_original_name'
    ];
    public static function generateSlug($string)
    {

        $slug =  Str::slug($string, '-');
        $original_slug = $slug;

        $exists = Project::where('slug', $slug)->first();
        $c = 1;

        while ($exists) {
            $slug = $original_slug . '-' . $c;
            $exists = Project::where('slug', $slug)->first();
            $c++;
        }
        return $slug;
    }
}
