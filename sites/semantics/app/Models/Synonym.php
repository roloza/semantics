<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Synonym extends Model
{
    use HasFactory;

    protected $table = 'synonyms';

    protected $fillable = [
        'racine',
        'cat_grammatical',
        'words',
    ];

    public static function fuzzySearch($word, $maxWords = 30, $first = false)
    {
        if ($word === '') {
            return [];
        }
        $query = self::query();
        $query->select('racine', DB::raw('group_concat(words,"|") as words'));
        $words = self::getLevenshtein1($word);
        foreach($words as $word) {
            $query->orWhere('racine', 'LIKE', '%' . $word . '%');
        }
        $query->groupBy('racine');
        $collection = $query->get();
        $list = $collection->toArray();
        $options = [
            'keys' => ['racine'],
            'includeScore' => true,
            // 'threshold' => 0.3
        ];
        $fuse = new \Fuse\Fuse($list, $options);
        $collection = collect($fuse->search($word))->take(10);
        $results = [];
        foreach($collection as $items) {
            $words = explode('|', $items['item']['words']);
            $results[] = [
                'racine' => $items['item']['racine'],
                'words' => array_slice($words, 0, $maxWords)
            ];

        }

        if ($first) {
            return collect($results)->first();
        }

        return $results;
    }

    public static function fuzzySearchByExpression($expression, $maxWords = 10)
    {
        $res = [];
        $words = explode(' ', $expression);
        foreach($words as $word) {
            $res[$word] = self::fuzzySearch($word, $maxWords, true);
        }
        return $res;
    }


    private static function getLevenshtein1($word)
    {
        $words = array();
        for ($i = 0; $i < strlen($word); $i++) {
            // insertions
            $words[] = substr($word, 0, $i) . '_' . substr($word, $i);
            // deletions
            $words[] = substr($word, 0, $i) . substr($word, $i + 1);
            // substitutions
            $words[] = substr($word, 0, $i) . '_' . substr($word, $i + 1);
        }
        // last insertion
        $words[] = $word . '_';
        return $words;
    }
}
