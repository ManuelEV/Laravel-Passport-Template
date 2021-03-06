<?php

namespace App\Http\Controllers\Api;

use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\ClientException;

class AuthenticationController extends Controller
{
    public function getTokensFirstTime () {
    	try {
		    $query = http_build_query([
			    'client_id' => env('PASSPORT_CLIENT_ID'),
			    'redirect_uri' => env('PASSPORT_URL_CALLBACK'),
			    'response_type' => 'code',
			    'scope' => 'show-products',
		    ]);
	    } catch (\Exception $exception) {
		    return response()->json($exception->getMessage(), $exception->getCode());
	    }

	    return redirect(env('PASSPORT_URL_REDIRECT_AUTHORIZE') . '?'.$query );
    }

    public function callback () {
	    if (request('error') && request('error') === 'access_denied') {
		    return response()->json('acceso denegado', 401);
	    }

	    $http = new Client;
	    $response = $http->post(env('PASSPORT_URL_POST_TOKEN'), [
		    'verify' => false,
		    'form_params' => [
			    'grant_type' => 'authorization_code',
			    'client_id' => env('PASSPORT_CLIENT_ID'),
			    'client_secret' => env('PASSPORT_SECRET'),
			    'redirect_uri' => env('PASSPORT_URL_CALLBACK'),
			    'code' => request('code'),
		    ],
	    ]);

	    $data = json_decode((string) $response->getBody(), true);
	    $app = \App\App::firstOrCreate(['id' => 1]);
	    $app->access_token = $data['access_token'];
	    $app->refresh_token = $data['refresh_token'];
	    $app->save();

	    session()->flash('status', 'Los tokens se han generado y guardado satisfactoriamente');
	    return redirect('/home');
    }

	public function refreshToken () {
		$http = new Client;
		$response = null;
		try {
			$app = \App\App::first();
			$response = $http->post(env('PASSPORT_URL_POST_TOKEN'), [
				'verify' => false,
				'form_params' => [
					'grant_type' => 'refresh_token',
					'client_id' => env('PASSPORT_CLIENT_ID'),
					'client_secret' => env('PASSPORT_SECRET'),
					'redirect_uri' => env('PASSPORT_URL_CALLBACK'),
					'refresh_token' => $app->refresh_token
				],
			]);

			$data = json_decode((string) $response->getBody(), true);
			if ($data) {
				$app->access_token = $data['access_token'];
				$app->refresh_token = $data['refresh_token'];
				$app->save();
			}
		} catch (ClientException $exception) {
			session()->flash('status', 'Los tokens expirado, conecte de nuevo con la API');
			return redirect('/home');
		}

		return back();
	}
}
