<?php

namespace App\Http\Controllers\Application\Users;

use App\Http\Controllers\Controller;
use App\Models\Application\User;
use App\Models\Application\UserNote;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        return Inertia::render('Users/Index', [
            'users'    => fn () => $this->queryUsers($request),
            'notes'    => Inertia::lazy(function () use ($request) {
                return $this->queyUserNotes($request);
            }),
            'filterMode' => $request->has('term') && $request->get('term') !== '',
        ]);
    }

    protected function queryUsers(Request $request): LengthAwarePaginator
    {
        $users = User::query();

        if ($request->has('term') && $request->get('term') !== '') {
            $users = $users->where(
                $request->get('type', 'name'),
                'like',
                "%{$request->get('term')}%"
            );
        }

        /**
         * @var \Illuminate\Pagination\LengthAwarePaginator $users
         */
        $users = $users->orderBy('created_at', 'desc')
            ->paginate(15);

        if ($request->has('firstId')) {
            $user = User::findOrFail($request->get('firstId'));

            $pagination = $users->toArray();

            $users = $users->filter(function ($item) use ($user) {
                return $item->id !== $user->id;
            });

            $users = $users->prepend($user);

            $pagination['data'] = $users->toArray();

            $users = $pagination;
        }

        return $users;
    }

    protected function queyUserNotes(Request $request): LengthAwarePaginator
    {
        $notes = UserNote::query()
            ->whereUserId($request->get('userId'))
            ->with(['createdBy'])
            ->orderby('date', 'desc')
            ->paginate(15);

        return $notes;
    }
}
