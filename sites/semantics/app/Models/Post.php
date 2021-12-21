<?php


namespace App\Models;

use App\Concerns\AttachableConcern;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use AttachableConcern;
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = ['name', 'slug', 'image_id', 'category_id', 'parent_id', 'description', 'keywords', 'author', 'content', 'published'];

    protected $with = ['tags', 'category', 'image'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public static function draft()
    {
        return self::firstOrCreate(['name' => null], ['content' => '']);
    }

    public function scopeNotDraft($query)
    {
        return $query->whereNotNull('name');
    }

    public function scopeOnline($query)
    {
        return $query->where('published', true);
    }

    public function saveTags(string $tags)
    {

        $tags = array_filter(array_unique(array_map(function ($item) {
            return trim($item);
        }, explode(',', $tags))), function ($item) {
            return !empty($item);
        });

        if (empty($tags)) {
            $this->tags()->sync([]);
            return false;
        }

        $persistedTags = Tag::whereIn('name', $tags)->get();
        $tagsToCreate = array_diff($tags, $persistedTags->pluck('name')->all()); // On récupère uniquement la différence entre les tags existants et les tags "à créer"

        $tagsToCreate = array_map(function ($tag) {
            return ['name' => $tag, 'slug' => Str::slug($tag)];
        }, $tagsToCreate);
        $createdTags = $this->tags()->createMany($tagsToCreate);
        $persistedTags = $persistedTags->merge($createdTags);
        $this->tags()->sync($persistedTags);
    }

}