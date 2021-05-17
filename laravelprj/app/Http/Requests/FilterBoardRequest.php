<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;

class FilterBoardRequest extends Request
{
    public function rules()
    {

        return [
            request()->input('limit')  => 'size:1,10',
            request()->input('sortfield')   => 'in:created_at,title',
            request()->input('sortmethod')  => 'in:asc,desc',
            request()->input('search') => 'Minus',
        ];
    }
}
