<?php

namespace App\Concerns;

use App\Models\Attachment;

trait AttachableConcern
{

    public static function bootAttachableConcern()
    {
        // $subject -> Pour l'instant il s'agit du post
        // A la suppression d'un post
        self::deleted(function($subject) {
            foreach ($subject->attachments()->get() as $attachment) {
                $attachment->deleteFile();
            }
            $subject->attachments()->delete();
        });

        // A l'édition d'un post
        self::updating(function($subject) {
            // test si le contenu est différent de l'original
            if ($subject->content != $subject->getOriginal('content')) {
                // Regex : On cherche une chaine de caractère qui contient src et dans ce src, n'importe quel caractère sauf "
                // S'il y a plusieurs matches, c'est qu'on a plusieurs images
                if(preg_match_all('/src="([^"]+)"/', $subject->content, $matches) > 0) {
                    $images = array_map(function($match) {
                        return basename($match);
                    }, $matches[1]);
                    $attachments = $subject->attachments()->whereNotIn('name', $images);
                } else {
                    $attachments = $subject->attachments();
                }

                foreach ($attachments->get() as $attachment) {
                    $attachment->deleteFile();
                }
                $attachments->delete();
            }
        });
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

}