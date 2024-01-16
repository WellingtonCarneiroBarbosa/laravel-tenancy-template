<?php

namespace App\Http\Controllers\Application\Students;

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
        return Inertia::render('Students/Index', [
            'students' => fn () => $this->queryStudents($request),
            'notes'    => Inertia::lazy(function () use ($request) {
                return $this->queyStudentNotes($request);
            }),
        ]);
    }

    protected function queryStudents(Request $request): LengthAwarePaginator
    {
        $students = User::query();

        /**
         * @var \Illuminate\Pagination\LengthAwarePaginator $students
         */
        $students = $students->orderBy('created_at', 'desc')
            ->paginate(15);

        if ($request->has('firstId')) {
            $student = User::findOrFail($request->get('firstId'));

            $pagination = $students->toArray();

            $students = $students->filter(function ($item) use ($student) {
                return $item->id !== $student->id;
            });

            $students = $students->prepend($student);

            $pagination['data'] = $students->toArray();

            $students = $pagination;
        }

        return $students;
    }

    protected function queyStudentNotes(Request $request): LengthAwarePaginator
    {
        $notes = UserNote::query()
            ->whereUserId($request->get('studentId'))
            ->with(['createdBy'])
            ->orderby('date', 'desc')
            ->paginate(15);

        return $notes;
    }
}
