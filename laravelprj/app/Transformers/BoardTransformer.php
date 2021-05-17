<?php

namespace App\Transformers;

use App\Board;
use League\Fractal\TransformerAbstract;
use League\Fractal\ParamBag;
use League\Fractal\Manager;
use Dingo\Api\Contract\Transformer\Adapter;
class BoardTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['writer', 'attachments'];
    protected $defaultIncludes = [];
    protected $visible = [];
    protected $hidden = [];
    private $validParams = ['limit', 'order'];

    public function transform(Board $board)
    {
        $payload = [
            'id' => (int) $board->id,
            'title' => $board->title,
            'content_raw'  => strip_tags($board->content),
            'contant_html' => markdown($board->content),
            'created' => $board->created_at->toIso8601String(),
            'link' => [
                'rel' => 'self',
                'href' => route('api.v1.board.show', $board->id),
            ],

        ];
        $fractal = new Manager();
        if (isset($_GET['include'])) {
            $fractal->parseIncludes($_GET['include']);
        }

        return $payload;
    }


    public function includeWriter(Board $board, ParamBag $paramBag = null)
    {
        return $this->item(
            $board->writer,
            new \App\Transformers\UserTransformer($paramBag)
        );
    }

    public function includeAttachments(Board $board, ParamBag $paramBag = null)
    {
        if ($paramBag === null) {
            return $board->attachments();
        }
        $usedParams = array_keys(iterator_to_array($paramBag));
        if ($invalidParams = array_diff($usedParams, $this->validParams)) {
            throw new \Exception(sprintf(
                'Invalid param(s): "%s". Valid param(s): "%s"',
                implode(',', $usedParams),
                implode(',', $this->validParams)
            ));
        }
        list($limit, $offset) = $paramBag->get('limit');
        list($orderCol, $orderBy) = $paramBag->get('order');
        $attachments = $board->attachments()
            ->take($limit)
            ->skip($offset)
            ->orderBy($orderCol, $orderBy)
            ->get();
        return $this->collection($attachments, new \App\Transformers\AttachmentTransformer());
    }
}
