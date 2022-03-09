<?php

use App\AwsCognitoIdentitySRP;
use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('test', function () {
    $client = new CognitoIdentityProviderClient([
        'version' => '2016-04-18',
        'region' => 'ap-southeast-1',
        'credentials' => false,
    ]);

    $srp = new AwsCognitoIdentitySRP($client, '180p05bhs2kn2rb63vcv14p40l', 'ap-southeast-1_fG99nG2fq');

    $result = $srp->authenticateUser('aaron.chua@', 'Stfx123#');

    if (! $result) {
        throw new \RuntimeException('Unable to obtain access token from AWS CognitoIdp.');
    }

    var_dump($result->toArray());
});
