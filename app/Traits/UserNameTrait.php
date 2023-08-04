<?php

namespace App\Traits;

use App\Models\Guardian;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

trait UserNameTrait {

    // Student username
    public function studentUserNameGenerate($first_name, $last_name)
    {
        $userName = $first_name . mt_rand(10000, 99999) . $last_name;

        if($this->studentUserNameExists($userName))
            return $this->studentUserNameGenerate($first_name, $last_name);

        return $userName;
    }

    public function studentUserNameExists($userName)
    {
        return Student::where('username', $userName)->exists();
    }


    // Teacher username
    public function teacherUserNameGenerate($first_name, $last_name)
    {
        $userName = $first_name . mt_rand(10000, 99999) . $last_name;

        if($this->teacherUserNameExists($userName))
            return $this->teacherUserNameGenerate($first_name, $last_name);

        return $userName;
    }

    public function teacherUserNameExists($userName)
    {
        return Teacher::where('username', $userName)->exists();
    }

    // Guardian username
    public function guardianUserNameGenerate($first_name, $last_name)
    {
        $userName = $first_name . mt_rand(10000, 99999) . $last_name;

        if($this->guardianUserNameExists($userName))
            return $this->guardianUserNameGenerate($first_name, $last_name);

        return $userName;
    }

    public function guardianUserNameExists($userName)
    {
        return Guardian::where('username', $userName)->exists();
    }
}
