<?php

namespace App\Http\Controllers\Application\Students;

use App\Http\Controllers\Controller;
use App\Models\Application\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function __invoke(Request $request)
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

        return Inertia::render('Students/Index', [
            'students' => $students,
        ]);
    }
}
