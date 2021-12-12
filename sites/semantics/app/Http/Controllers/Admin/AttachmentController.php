<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\AttachmentRequest;
use App\Models\Attachment;
use Illuminate\Http\JsonResponse;

class AttachmentController extends Controller
{

    public function store(AttachmentRequest $request)
    {
        //Vérifier attachable_type Ok
        $type = $request->get('attachable_type');
        $id = $request->get('attachable_id');
        $file = $request->file('image');
        if (class_exists($type) && method_exists($type, 'attachments')) {
            $subject = call_user_func($type . '::find', $id);
            if ($subject) {
                $attachment = new Attachment($request->only('attachable_type', 'attachable_id'));
                $attachment->uploadFile($file);
                $attachment->save();
               return $attachment;
            } else {
                return new JsonResponse(['attachable_id' => 'Ce contenu ne peux pas recevoir de fichiers attachés'], 422);
            }
        } else {
            return new JsonResponse(['attachable_type' => 'Ce contenu ne peux pas recevoir de fichiers attachés'], 422);
        }
    }

}