<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypegaleriRequest;
use App\Http\Resources\TypegaleriResource;
use App\Models\Typegaleri;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;


class TypegaleriController extends Controller
{
    private function getTypegaleri(User $user, int $idtypegaleri): Typegaleri
    {
        $typegaleri = Typegaleri::where('id', $idtypegaleri)->where('user_id', $user->id)->first();
        if (!$typegaleri) {
            throw new HttpResponseException(response([
                "errors" => [
                    "message" => [
                        "not found"
                    ],
                ]
            ])->setStatusCode(404));
        }
        return $typegaleri;
    }
    public function store(TypegaleriRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = Auth::user();
        $typegaleri = new Typegaleri($data);
        $typegaleri->user_id = $user->id;
        $typegaleri->save();
        return (new TypegaleriResource($typegaleri))->response()->setStatusCode(201);
    }
    public function get(): JsonResponse
    {
        $typegaleri = Typegaleri::all();
        return response()->json([
            'data' => TypegaleriResource::collection($typegaleri),
        ]);
    }

    public function getid(int $idtypegaleri): TypegaleriResource
    {
        $user = Auth::user();
        $typegaleri = $this->getTypegaleri($user, $idtypegaleri);
        return new TypegaleriResource($typegaleri);
    }
    public function update(int $id, TypegaleriRequest $request): JsonResponse
    {
        $user = Auth::user();
        $typegaleri = $this->getTypegaleri($user, $id);
        $data = $request->validated();
        $typegaleri->fill($data);
        $typegaleri->save();
        return response()->json([
            "message" => "Data Berhasil di Update!",
            "data" => new TypegaleriResource($typegaleri)
        ], 200);
    }
    public function delete(int $idtypegaleri): JsonResponse
    {
        $user = Auth::user();
        $typegaleri = $this->getTypegaleri($user, $idtypegaleri);
        $typegaleri->delete();
        return response()->json([
            'data' => true,
            'message' => 'Data Berhasil di Hapus!'
        ])->setStatusCode(200);
    }
}
