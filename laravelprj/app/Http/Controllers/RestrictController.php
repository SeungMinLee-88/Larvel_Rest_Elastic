<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Hall;
Use App\Restrict;
class RestrictController extends Controller
{
    public function restrict(Request $request)
    {
        $hall = Hall::find($request->hall_id);

        $hall->restrict()->create([
            'hall_id'     => $request->hall_id,
            'reserve_date'    => $request->inputDate,
        ]);
        flash()->success("restrict is succeed");

        return back();
    }

    public function unrestrict(Request $request)
    {
        Restrict::where('hall_id', $request->hall_id)->where('reserve_date', $request->inputDate)->delete();
        flash()->success("restrict cancel is succeed");

        return back();
    }
}
