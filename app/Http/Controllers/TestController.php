<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestRequest;
use App\Transformers\TestTransformer;
use App\Validators\TestPreset;
use Illuminate\Http\Request;
use JenKy\ValidationPresets\ValidatesWithPresets;
use Spatie\Fractalistic\ArraySerializer;

class TestController extends Controller
{
    use ValidatesWithPresets;

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
        return response()->fractal(\App\User::all(), new TestTransformer, new ArraySerializer);
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

    public function request(TestRequest $request)
    {
    }

    public function controller()
    {
        $this->preset(new TestPreset);
    }
}
