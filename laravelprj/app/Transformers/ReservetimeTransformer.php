<?php

namespace App\Transformers;

use App\Reservetime;
use League\Fractal\TransformerAbstract;
use League\Fractal\ParamBag;
use League\Fractal\Manager;
use Dingo\Api\Contract\Transformer\Adapter;
class ReservetimeTransformer extends TransformerAbstract
{
    protected $availableIncludes = [];
    protected $defaultIncludes = [];
    protected $visible = [];
    protected $hidden = [];
    private $validParams = [];

    public function transform(Reservetime $reservetime)
    {
        $payload = [
            'id' => $reservetime->id,
            'reservetime' => $reservetime->reservetime,
        ];

        return $payload;
    }
}
