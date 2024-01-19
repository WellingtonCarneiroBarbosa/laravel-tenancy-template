<?php

namespace App\Http\Controllers\Application\Users;

use App\Http\Controllers\Controller;
use App\Models\Application\User;

class DeleteController extends Controller
{
    public function __invoke(string $id)
    {
        $user = User::findOrFail($id);

        $this->authorize('delete', $user);

        $user->delete();

        return redirect()->route('app.users.index')
            ->with('flash', [
                'type'    => 'success',
                'message' => "Aluno {$user->name} removido com sucesso!",
            ]);
    }
}
