<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['students'] = Student::orderBy('id','asc')->paginate(4);
        return view('students.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules  = array(
            'firstname' => 'required',
            'lastname' => 'required',
            'gender' => 'required',
            'country' => 'required',
            'city' => 'required',
            'address' => 'required'
            // 'img' => 'required|image|max:2048'
           );
    
            $errors = Validator::make($request->all(), $rules);
            if($errors->fails())
            {
                return response()->json(['errors' => $errors->errors()->all()]);
            }
            
    
            $students = array(
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'gender' => $request->gender,
                'country' => $request->country,
                'city' => $request->city,
                'address' => $request->address
                // 'img' => $new_image_name
            );
    
            student::create($students);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $data = $request->all();
        echo "<pre>"; print_r($data); die;
        $student = Students::findOrfail($request->student_id);
        return view('students.index', compact('students'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $students = Students::find($id);
        return view('student.index', compact('students'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'gender' => 'required',
            'country' => 'required',
            'city' => 'required',
            'address' => 'required',
        ]);

        $student = array(
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'gender' => $request->gender,
            'country' => $request->country,
            'city' => $request->city,
            'address' => $request->address,
        );
         $data = $request->all();
        // echo "<pre>"; print_r($data); die;
         
       Students::findOrfail($request->student_id)->update($student);

       return redirect()->route('students.index')->with('success', 'Student Successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = $request->all();
        // echo "<pre>"; print_r($data); die;

        $students = Student::findOrfail($request->student_id);
        $students->delete();

        return redirect()->route('students.index')->with('success', 'Students deletd successful.');
    }
}
