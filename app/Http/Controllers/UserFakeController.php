<?php

namespace App\Http\Controllers;

use App\Models\FakeUser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class UserFakeController extends Controller
{

    public function getUsers(Request $request) {
        $offset = 0;
        $limit = 50;
        if ($request->has('from')) {
            $offset = $request->input('from');
        }
        if ($request->has('size')) {
            $limit = $request->input('size');
        }
        $totalCount = FakeUser::all()->count();
        $result = [
            'from' => $offset,
            'size' => $limit,
            'totalHits' => $totalCount,
        ];
        $users = FakeUser::orderBy('idns', 'ASC')
            ->skip($offset)
            ->take($limit)
            ->get();
        $result['hits'] = $this->processUsers($users);

        return response()->json($result);
    }

    protected function processUsers(Collection $users): array {
        $res = [];
        foreach ($users as $user) {
            $res[] = [
                'id' => $user->id,
                'type' => 'annuarie',
                'score' => 1,
                'source' => $user,
            ];
        }

        return $res;
    }
}
