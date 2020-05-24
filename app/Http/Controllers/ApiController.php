<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Candidate;
use GuzzleHttp\Client;


class ApiController extends Controller
{
    public function search(Request $request) {
        // $location = $request->location;
        // $link = "https//api.github.com/search/users?q=location:";
        // $link = $link . $location;
        // $response = Http::get("https://api.github.com/search/users?q=location:" . $location);
        // $json = $response->json();
        // $users = $json['items'];
        
        $request_query = parse_url($request->fullUrl(),PHP_URL_QUERY);
        $change        = array("=" => ":", "&" => "+");
        $query         = strtr($request_query,$change);

        $users = Http::get("https://api.github.com/search/users?q=" . $query)->json()['items'];

        return response()->json($users, 200);
    }

    public function review(Request $request) {
        $user = $request->github_username;

        $response = Http::get("https://api.github.com/search/users?q=user:" . $user)->json();
        
        if (in_array('Validation Failed',$response)) {
            $message = "Sorry, but " . $user . " doesn't exist !";
            $code = 404;
        }
        else {
            $candidate = new Candidate($request->all());
                
            if($candidate->save()) {
                $message = $user . " added to list of candidates";
                $code    = 201;
            }
            else {
                $message = "Oops. Somethng wrong is not right";
                $code    = 500;
            }
        }
        return response()->json(["message" => $message], $code);
    }
        // $response = Http::get("https://api.github.com/search/users?q=user:" . $user);
        // $json = $response->json();

        // return response()->json($json, 200);

    public function list() {
        $candidates = Candidate::get();

        return response()->json($candidates,200);
    }

    public function test() {
        $client = new Client();
        $response = $client->request('GET', 'https://api.github.com/search/users?q=user:xicon73/repos', ['headers' =>  ['token ' . $_ENV['GITHUB_TOKEN']]]);
        // $res=$response->getBody()->getContents();
        dd($response);

    }
}



// $response = Http::withHeaders([
        //     'X-First' => 'foo',
        //     'X-Second' => 'bar'
        // ])->get('http://test.com/users', [
        //     'name' => 'Taylor',
        // ]);