<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganisasiCreateRequest;
use App\Http\Resources\OrganisasiResource;
use App\Models\Organisasi;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;


class OrganisasiController extends Controller
{
    private function getOrganisasi(User $user, int $idorgs)
    {
        $organisasi = Organisasi::query()->where('user_id', $user->id)->where('id', $idorgs)->first();
        if (!$organisasi) {
            throw new HttpResponseException(response([
                "errors" => [
                    "message" => [
                        "not found"
                    ],
                ]
            ])->setStatusCode(404));
        }
        return $organisasi;
    }

    public function create(OrganisasiCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = Auth::user();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $originalName = $file->getClientOriginalName();
            $uniqueName = time() . '_' . $originalName;
            $filepath = $file->storeAs('uploads/organisasi', $uniqueName, 'public');
            $data['image'] = $filepath;
        }
        $organisasi = new Organisasi($data);
        $organisasi->user_id = $user->id;
        $organisasi->save();

        return response()->json([
            'message' => 'Data Berhasil di Buat',
            'data' => new OrganisasiResource($organisasi),
        ]);
    }

    public function get(): JsonResponse
    {
        $organisasi = Organisasi::all();
        return response()->json([
            'data' => OrganisasiResource::collection($organisasi),
        ]);
    }

    public function update(int $idorgs, OrganisasiCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = Auth::user();
        dd($data);
        $organisasi = $this->getOrganisasi($user, $idorgs);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $originalName = $file->getClientOriginalName();
            $uniqueName = time() . '_' . $originalName;
            $filepath = $file->storeAs('uploads/organisasi', $uniqueName, 'public');
            $data['image'] = $filepath;

            if ($organisasi->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($organisasi->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($organisasi->image);
            }
        }

        $organisasi->update($data);

        return response()->json([
            'message' => 'Data Berhasil di Update',
            'data' => new OrganisasiResource($organisasi),
        ]);
    }




    public function getid(int $idorgs): OrganisasiResource
    {
        $user = Auth::user();
        $organisasi = $this->getOrganisasi($user, $idorgs);
        return new OrganisasiResource($organisasi);
    }
    public function delete(int $idorgs): JsonResponse
    {
        $user = Auth::user();
        $organisasi = $this->getOrganisasi($user, $idorgs);
        $organisasi->delete();
        return response()->json([
            'data' => true,
            'message' => 'Data Berhasil di Hapus!'
        ]);
    }
}
