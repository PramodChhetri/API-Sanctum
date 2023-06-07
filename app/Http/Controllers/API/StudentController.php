<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\MockObject\Builder\Stub;

class StudentController extends Controller
{
    // Register API
    public function register(Request $request)
    {  
        // Validation
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required | email | unique:students',
            'password' => 'required | confirmed',
        ]);

        // Hashing Password
        $data['password'] = Hash::make($request->password);

        // Checking phone_no
        if($request->phone_no)
        {
            $data['phone_no'] = $request->phone_no;
        }

        // Inserting Data to Student
        Student::create($data);

        // Sending Response
        return response()->json([
            "status" => 1,
            "message" => "Student registered successfully.",
            "data" => $data
        ]);

    }

    // Login API
    public function login(Request $request)
    {
        // Validation
        $data = $request->validate([
            'email' => 'required | email',
            'password' => 'required',
        ]);

        // Checking Student
        $student = Student::where("email","=",$request->email)->first();
        if($student)
        {
            if(Hash::check($request->password,$student->password))
            {
                // Creating Token
                $token = $student->createToken('auth_token')->plainTextToken;

                // Sendind Response
                return response()->json([
                    "status" => 1,
                    "message" => "Student logged in Successfull.",
                    "access_token" => $token
                ], 404);
            }
            else
            {
                return response()->json([
                    "status" => 0,
                    "message" => "Password doesnot match!"
                ], 404);
            }
        }
        else
        {
            return response()->json([
                "status" => 0,
                "message" => "Student not found!"
            ], 404);
        }

    }

    // Profile API
    public function profile()
    {
        return response()->json([
            "status" => 1,
            "message" => "Student Profile Information.",
            "data" => auth()->user()
        ]);
    }

    // Logout API
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            "status" => 1,
            "message" => "Sucessfully logged out."
        ]);
    }

}

/*
* --Note--
* 1) Register and Login don't need Authentication.
* 2) Profile and Logout need Authentication( Sanctum ).
*
*/