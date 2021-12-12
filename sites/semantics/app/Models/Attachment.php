<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    use HasFactory;

    protected $table = 'attachments';

    protected $appends = ['url'];

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        self::deleted(function($attachment) {
            $attachment->deleteFile();
        });
    }



    public function attachable()
    {
        return $this->morphTo();
    }

    public function uploadFile(UploadedFile $file)
    {
        $file = $file->storePublicly('uploads', ['disk' => 'public']);
        $this->name = basename($file);
        return $this;
    }

    public function deleteFile()
    {
        Storage::disk('public')->delete('/uploads/' . $this->name);
    }

    public function getUrlAttribute()
    {
        return Storage::disk('public')->url('/uploads/' . $this->name);
    }


}