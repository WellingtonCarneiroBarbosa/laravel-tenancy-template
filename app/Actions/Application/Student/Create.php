<?php

namespace App\Actions\Application\Student;

use App\Http\Requests\Application\Students\CreateRequest;
use App\Models\Application\User;
use App\Notifications\Application\Students\CreatedNotification;
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

        if ($data['access_expires_at'] !== '0') {
            $expiresAt = now()->addDays(
                $data['access_expires_at']
            );
        } else {
            $expiresAt = null;
        }

        unset($data['access_expires_at']);

        $student = new User();

        $student->forceFill($data);
        $student->access_expires_at = $expiresAt;

        $chars = ['!', '@', '#', '$', '%', '&', '*'];

        $specialChars = implode(
            array_rand(
                array_flip($chars),
                random_int(1, 3)
            )
        );

        $password = str_shuffle(
            random_int(1000, 9999) .
                Str::random(6) .
                $specialChars
        );

        $student->password = $password;

        $student->save();

        $student->notify(new CreatedNotification(
            password: $password,
            loginCode: auth()->user()->currentTeam->share_code,
        ));

        return $student;
    }
}
