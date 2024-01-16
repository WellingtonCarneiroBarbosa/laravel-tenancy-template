<?php

namespace App\Http\Controllers\Application\Students;

use App\Http\Controllers\Controller;
use App\Models\Application\User;

class DeleteController extends Controller
{
    public function __invoke(string $id)
    {
        $student = User::findOrFail($id);

        $this->authorize('delete', $student);

        $student->delete();

        return redirect()->route('app.students.index')
            ->with('flash', [
                'type'    => 'success',
                'message' => "Aluno {$student->name} removido com sucesso!",
            ]);
    }
}
