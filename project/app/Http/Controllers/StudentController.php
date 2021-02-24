<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class StudentController extends Controller
{

    public function index(){
        $students= Student::get();
        return view('welcome',compact('students'));
    }
    public function store(Request $request){

        $validator=Validator::make($request->all(),[

            'firstname'=>'required',
            'lastname'=>'required',
            'email'=>'required',
            'phone'=>'required',

        ]);
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
          }

        $student=new Student();
        $student->firstname=$request->firstname;
        $student->lastname=$request->lastname;
        $student->email=$request->email;
        $student->phone=$request->phone;
        $student->save();
        $msg = 'Data Added Successfully';
        return response()->json($msg);


    }
    public function update(Request $request, $id){

        $validator=Validator::make($request->all(),[

            'firstname'=>'required',
            'lastname'=>'required',
            'email'=>'required',
            'phone'=>'required',

        ]);
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
          }


          $student=Student::findOrFail($id);
          $student->firstname=$request->firstname;
          $student->lastname=$request->lastname;
          $student->email=$request->email;
          $student->phone=$request->phone;
          $student->update();
          $msg = 'Data Updated Successfully';
          return response()->json($msg);

    }
    public function delete($id){
        $student=Student::findOrFail($id);
        $student->delete();
        $msg = __('Data Deleted Successfully.');
        return response()->json($msg);


    }
}
