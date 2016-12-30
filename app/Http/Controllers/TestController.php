<?php

namespace App\Http\Controllers;

use App\Transformers\TestTransformer;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function validation(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'test' => 'required',
        ]);
    }

    public function model()
    {
        return \App\User::findOrFail(100);
    }

    public function transformer()
    {
        return response()->transform(\App\User::paginate(), new TestTransformer);
    }

    public function exception()
    {
        throw new \App\Exceptions\TestException("Error Processing Request");
    }

    public function users()
    {
        return \App\User::filterBy('id', 'first_name')
            ->sortBy('first_name')->get();
    }
}
