<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Candidate;
use GuzzleHttp\Client;


class ApiController extends Controller
{
    public function search(Request $request) {
        $request_query = parse_url($request->fullUrl(),PHP_URL_QUERY);
        $change        = array("=" => ":", "&" => "+");
        $query         = strtr($request_query,$change);

        $client   = new Client();
        $response = $client->request('GET', 'https://api.github.com/search/users?q='.$query, ['headers' =>  [ 'Authorization' => 'token ' . config('services.github.token')], 'exceptions' => false, 'timeout' => 300]);
        $users    = json_decode($response->getBody())->items;

        if (empty($users)) {
            return response()->json(["message" => "Não existem candidatos com os filtros inseridos"], 404);
        }

        return response()->json($users, 200);
    }

    public function review(Request $request) {
        $client   = new Client();
        $username = $request->github_username;
        $user     = $client->request('GET', 'https://api.github.com/users/'.$username, ['headers' =>  [ 'Authorization' => 'token ' . config('services.github.token')]]);
        $user     = json_decode($user->getBody(), TRUE);

        $repositories = $client->request('GET', 'https://api.github.com/users/'.$username.'/repos', ['headers' =>  [ 'Authorization' => 'token ' . config('services.github.token')]]);
        $repos        = json_decode($repositories->getBody(), TRUE);

        $candidate                   = new Candidate($user);
        $candidate->github_username  = $request->github_username;
        $candidate->job_category     = $request->job_category;
        $candidate->skill_level      = $request->skill_level;
        $candidate->fit_for_job      = $request->fit_for_job;
        $candidate->commentary_notes = $request->commentary_notes;

        if($candidate->save()) {
            $candidate->repositories()->createMany($repos);
            $message = $username . " adicionado à lista de candidatos";
            $code    = 201;
        }
        else {
            $message = "Oops. Something wrong is not right";
            $code    = 400;
        }

        return response()->json(["message" => $message], $code);
    }

    public function list() {
        $candidates = Candidate::with('repositories')->get();

        return response()->json($candidates,200);
    }

    public function test() {
        $client = new Client();
        $response = $client->request('GET', 'https://api.github.com/users/xicon73', ['headers' =>  [ 'Authorization' => 'token ' . $_ENV['GITHUB_TOKEN']]]);
        $res=$response->getBody()->getContents();
        dd($res);

    }
}