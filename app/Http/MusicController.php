<?php

namespace App\Http;

use App\Core\Support\Controller;
use App\Services\Music;
use Illuminate\Http\Request;

class MusicController extends Controller
{
    /**
     * @var Music
     */
    private $music;

    /**
     * MusicController constructor.
     * @param Music $music
     */
    public function __construct(Music $music)
    {
        $this->music = $music;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $results = $this->music->index($request->all());

        if (count($results) <= 0) {
            return response()->json(['data' => '', 'status' => 0], 404);
        }

        return response()->json(['data' => $results, 'status' => 1], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->music->store($request->all());

        return response()->json(['data' => $request->all(), 'status' => 1], 200);
    }
}
