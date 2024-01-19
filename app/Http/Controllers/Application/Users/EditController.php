<?php

namespace App\Http\Controllers\Application\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Users\UpdateRequest;
use App\Models\Application\User;
use Illuminate\Http\Request;

class EditController extends Controller
{
    public function __invoke(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $this->authorize('update', $user);

        return inertia('Users/Edit', [
            'user' => $user,
        ]);
    }

    public function update(UpdateRequest $request, string $id)
    {
        $user = User::findOrFail($id);

        $this->authorize('update', $user);

        $data = $request->validated();

        $expiresAt = $data['access_expires_at'];

        if ($expiresAt == 0) {
            $data['access_expires_at'] = null;
        }

        $user->update($data);

        return redirect()->route('app.users.index', [
            'firstId' => $user->id,
        ])
            ->with('flash', [
                'type'    => 'success',
                'message' => 'Informações do aluno atualizadas com sucesso!',
            ]);
    }
}
