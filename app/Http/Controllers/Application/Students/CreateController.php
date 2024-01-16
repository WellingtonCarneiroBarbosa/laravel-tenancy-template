<?php

namespace App\Http\Controllers\Application\Students;

use App\Actions\Application\Student\Create;
use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Students\CreateRequest;
use App\Models\Application\User;
use Inertia\Inertia;

class CreateController extends Controller
{
    public function __invoke()
    {
        $this->authorize('create', User::class);

        return Inertia::render('Students/Create');
    }

    public function store(CreateRequest $request)
    {
        $this->authorize('create', User::class);

        $studentCreator = new Create($request);
        $studentCreator->execute();

        return redirect()->route('app.students.index')
            ->with('flash', [
                'type'    => 'success',
                'message' => 'Aluno criado com sucesso! Acesso enviado por e-mail.',
            ]);
    }
}
