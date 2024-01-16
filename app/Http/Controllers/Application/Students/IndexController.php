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
        $students = User::query()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Students/Index', [
            'students' => $students,
        ]);
    }
}
