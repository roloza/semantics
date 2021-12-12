<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Class AttachmentTest
 * @package Tests\Feature
 */
class TaggableTest extends TestCase
{

    /**
     * Executé avant les tests
     */
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');

        Post::factory()->count(3)->create();
    }

    public function testCreateTags()
    {
        $post = Post::first();
        $post->saveTags('salut,chien,chat,chat'); // Création de 3 tags
        $this->assertEquals(3, Tag::count());
        $this->assertEquals(3, DB::table('post_tag')->count());
    }

    public function testEmptyTags()
    {
        $post = Post::where('id', 3)->first();
        $post->saveTags('');
        $this->assertEquals(0, Tag::count());
    }

    public function testReuseTags()
    {
        $post1 = Post::where('id', 1)->first();
        $post2 = Post::where('id', 2)->first();
        $post1->saveTags('salut , chien,chat, , , ');
        $post2->saveTags('salut,chameau');
        $this->assertEquals(4, Tag::count());
        $this->assertEquals(3, DB::table('post_tag')->where('post_id', $post1->id)->count());
        $this->assertEquals(2, DB::table('post_tag')->where('post_id', $post2->id)->count());
    }
}
