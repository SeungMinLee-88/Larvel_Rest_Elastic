<?php

namespace App\Transformers;

use App\Reserve;
use League\Fractal\TransformerAbstract;
use League\Fractal\ParamBag;
use League\Fractal\Manager;
use Dingo\Api\Contract\Transformer\Adapter;
class ReserveTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user', 'hall', 'reservetime'];
    protected $defaultIncludes = [];
    protected $visible = [];
    protected $hidden = [];
    private $validParams = ['limit', 'order'];

    public function transform(Reserve $reserve)
    {
        $payload = [
            'id' => (int) $reserve->id,
            'period' => $reserve->reserve_period,
            'date' => $reserve->reserve_date,
            'reason' => $reserve->reserve_reason,
        ];
        $fractal = new Manager();
        if (isset($_GET['include'])) {
            $fractal->parseIncludes($_GET['include']);
        }
        return $payload;
    }

    public function includeUser(Reserve $reserve, ParamBag $paramBag = null)
    {
        return $this->item(
            $reserve->user,
            new \App\Transformers\UserTransformer($paramBag)
        );
    }

    public function includeReservetime(Reserve $reserve, ParamBag $paramBag = null)
    {
        return $this->collection($reserve->reservetime, new \App\Transformers\ReservetimeTransformer($paramBag));
    }
}
