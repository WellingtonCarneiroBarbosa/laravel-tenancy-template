<?php

namespace App\Http\Controllers\Application\Users;

use App\Actions\Application\User\Create;
use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Users\CreateRequest;
use App\Models\Application\User;
use Inertia\Inertia;

class CreateController extends Controller
{
    public function __invoke()
    {
        $this->authorize('create', User::class);

        return Inertia::render('Users/Create');
    }

    public function store(CreateRequest $request)
    {
        $this->authorize('create', User::class);

        $userCreator = new Create($request);
        $userCreator->execute();

        return redirect()->route('app.users.index')
            ->with('flash', [
                'type'    => 'success',
                'message' => 'Aluno criado com sucesso! Acesso enviado por e-mail.',
            ]);
    }
}
