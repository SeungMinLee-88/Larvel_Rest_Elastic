<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;
use League\Fractal\ParamBag;
use League\Fractal\Manager;
use Dingo\Api\Contract\Transformer\Adapter;

class UserTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['depts'];
    protected $defaultIncludes = [];
    protected $visible = [];
    protected $hidden = [];
    public function transform(User $user)
    {
        $payload = [
            'id' => (int) $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'deptcode' => $user->deptcode,
        ];
        return $payload;
    }

    public function includeDepts(User $user, ParamBag $paramBag = null)
    {
        return $this->item(
            $user->depts,
            new \App\Transformers\DeptTransformer($paramBag)
        );
    }
}
