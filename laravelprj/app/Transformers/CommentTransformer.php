<?php

namespace App\Transformers;

use App\Comment;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\ParamBag;

class CommentTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'writer'
    ];
    protected $defaultIncludes = [];
    protected $visible = [];
    protected $hidden = [];

    public function transform(Comment $comment)
    {
        $payload = [
            'id' => (int) $comment->id,
            'created' => $comment->created_at->toIso8601String(),
            'link' => [
                 'rel' => 'self',
                 'href' => route('api.v1.comments.show', $comment->id),
            ],
        ];

        return $this->buildPayload($payload);
    }

    public function includeWriter(Comment $comment, ParamBag $paramBag = null)
    {
        return $this->item(
            $comment->writer,
            new \App\Transformers\UserTransformer($paramBag)
        );
    }
}
