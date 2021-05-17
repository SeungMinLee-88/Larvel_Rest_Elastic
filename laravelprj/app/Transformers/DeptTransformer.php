<?php

namespace App\Transformers;

use App\Dept;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;
use League\Fractal\ParamBag;

class DeptTransformer extends TransformerAbstract
{
    public function transform(Dept $dept)
    {
        $payload = [
            'deptcode' => $dept->deptcode,
            'deptname' => $dept->deptname,
        ];

        return $payload;
    }

}
