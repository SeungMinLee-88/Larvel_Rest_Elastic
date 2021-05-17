<?php

namespace App\Transformers;

use App\Attachment;
use League\Fractal\TransformerAbstract;
use League\Fractal\ParamBag;
use League\Fractal\Manager;
use Dingo\Api\Contract\Transformer\Adapter;

class AttachmentTransformer extends TransformerAbstract
{

    protected $visible = [];
    protected $hidden = [];

    public function transform(Attachment $attachment)
    {
        $payload = [
            'id' => (int) $attachment->id,
            'created' => $attachment->created_at->toIso8601String(),
            'link' => [
                 'rel' => 'self',
                 'href' => url(sprintf('http://%s:8000/attachments/%s', request()->getHost(), $attachment->name)),
            ],
        ];

        return $payload;
    }
}
