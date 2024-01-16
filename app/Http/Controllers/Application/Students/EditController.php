<?php

namespace App\Http\Controllers\Application\Students;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Students\UpdateRequest;
use App\Models\Application\User;
use Illuminate\Http\Request;

class EditController extends Controller
{
    public function __invoke(Request $request, string $id)
    {
        $student = User::findOrFail($id);

        $this->authorize('update', $student);

        return inertia('Students/Edit', [
            'student' => $student,
        ]);
    }

    public function update(UpdateRequest $request, string $id)
    {
        $student = User::findOrFail($id);

        $this->authorize('update', $student);

        $data = $request->validated();

        $expiresAt = $data['access_expires_at'];

        if ($expiresAt == 0) {
            $data['access_expires_at'] = null;
        }

        $student->update($data);

        return redirect()->route('app.students.index', [
            'firstId' => $student->id,
        ])
            ->with('flash', [
                'type'    => 'success',
                'message' => 'Informações do aluno atualizadas com sucesso!',
            ]);
    }
}
