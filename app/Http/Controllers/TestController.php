<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestRequest;
use App\Transformers\TestTransformer;
use App\User;
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
        return User::findOrFail(100);
    }

    public function transformer()
    {
        return response()->fractal(User::paginate(), new TestTransformer);
    }

    public function exception()
    {
        throw new \App\Exceptions\TestException("Error Processing Request");
    }

    public function users()
    {
        \Illuminate\Http\Resources\Json\Resource::withoutWrapping();
        // return \App\User::filterBy('id', 'first_name')
        //     ->sortBy('first_name')->get();
        return new \App\Http\Resources\User(User::first());
        return \App\Http\Resources\User::collection(User::all());
        // return new \App\Http\Resources\UserCollection(User::paginate());
    }

    public function request(TestRequest $request)
    {
    }

    public function controller()
    {
        $this->preset(new TestPreset);
    }
}
