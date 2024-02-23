<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(){
        $student = Student::all();
        $data = [
            'status'    => 200,
            'student'   => $student
        ];
        return response()->json($data, 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email|unique:students,email',
            'mobile'    => 'numeric'
        ]);
        if($validator->fails()){
            $data = [
                'status'    => 422,
                'message'   => $validator->messages()
            ];
            return response()->json($data, 422);
        }else{
            Student::newStudent($request);
            $data = [
                'status'    => 200,
                'message'   => 'data added successfully'
            ];
            return response()->json($data, 200);
        }
    }

    public function edit(Request $request, String $id){
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email',
            'mobile'    => 'numeric'
        ]);
        if($validator->fails()){
            $data = [
                'status'    => 422,
                'message'   => $validator->messages()
            ];
            return response()->json($data, 422);
        }else{
            Student::updateStudent($request, $id);
            $data = [
                'status'    => 200,
                'message'   => 'data updated successfully'
            ];
            return response()->json($data, 200);
        }
    }

    public function delete(String $id){
        Student::deleteStudent($id);
        $data = [
            'status'    => 200,
            'message'   => 'data deleted successfully'
        ];
        return response()->json($data, 200);
    }

}
