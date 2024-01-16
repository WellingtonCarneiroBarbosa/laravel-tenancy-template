<?php

namespace App\Actions\Application\Student;

use App\Http\Requests\Application\Students\CreateRequest;
use App\Models\Application\User;
use Illuminate\Support\Str;

class Create
{
    public function __construct(
        protected CreateRequest $request
    ) {
        //
    }

    public function execute(): User
    {
        $data = $this->request->validated();

        $student = new User();
        $student->forceFill($data);

        $password = Str::random(10);

        $student->password = $password;

        $student->save();

        return $student;
    }
}
