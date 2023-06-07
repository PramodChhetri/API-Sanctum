<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    // Create Project API
    public function createProject(Request $request)
    {
        // Validation
        $data = $request->validate([
            'name' => 'required | unique:projects',
            'description' => 'required',
            'duration' => 'required'
        ]);

        // Get ID & Create data
        $student_id = auth()->user()->id;
        $data['student_id'] = $student_id;

        Project::create($data);

        // Sending Response
        return response()->json([
            "status" => 1,
            "message" => "Project Successfully Created.",
            "data" => $data
        ]);

    }

    // List Project API
    public function listProject()
    {
        $student_id = auth()->user()->id;

        $projects = Project::where('student_id', $student_id)->get();

        return response()->json([
            "status" => 1,
            "message" => "Projects",
            "data" => $projects
        ]);
    }

    // Single Project API 
    public function singleProject($id)
    {
        $student_id = auth()->user()->id;

        if(Project::where([
            'id' => $id,
            'student_id' => $student_id
        ])->exists())
        {
            $details = Project::where([
                'id' => $id,
                'student_id' => $student_id
            ])->first();

            return response()->json([
                "status" => 1,
                "message" => "Project Details",
                "data" => $details
            ]);
        }
        else
        {
            return response()->json([
                "status" => 0,
                "message" => "Project not found"
            ]);
        }
    }

    // Delete Project API
    public function deleteProject($id)
    {
        $student_id = auth()->user()->id;

        if(Project::where([
            'id' => $id,
            'student_id' => $student_id
        ])->exists())
        {
            $project = Project::where([
                'id' => $id,
                'student_id' => $student_id
            ])->first();

            $project->delete();

            return response()->json([
                "status" => 1,
                "message" => "Project Deleted Successfully.",
            ]);
        }
        else
        {
            return response()->json([
                "status" => 0,
                "message" => "Project not found"
            ]);
        }

    }
}

/*
* --Note--
* 1) All Above method needs Authentication(Sanctum).
*/

