<?php

namespace App\Http\Controllers;

use App\PaymentGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentGradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grades = PaymentGrade::all();
        return view('administrator.setting.employee_grades.grades', compact('grades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrator.setting.employee_grades.add_grade');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validData = $this->validate($request , [
            'grade' => 'required',
            'basic_salary' => 'required',
            'yearly_increment_rate' => 'required',
            'house_rent' => 'required',
            'medical_allowance' => 'required',
            'travel_allowance' => 'required',
            'food_allowance' => 'required',
        ]);

        $result = PaymentGrade::create($validData + ['created_by' => auth()->user()->id]);
        $inserted_id = $result->id;
        if(!empty($inserted_id)){
            return redirect('/setting/employee_grades/create')->with('message', 'Added Successfully!');
        }else{
            return redirect('/setting/employee_grades/create')->with('exception', 'Operation Failed!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PaymentGrade  $paymentGrade
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentGrade $paymentGrade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaymentGrade  $paymentGrade
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $grade = PaymentGrade::where('id',$id)->first();
        return view('administrator.setting.employee_grades.edit_grade',compact('grade'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentGrade  $paymentGrade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $grade = PaymentGrade::find($request->grade_id);
        $this->validate($request, [
            'basic_salary' => 'required',
            'yearly_increment_rate' => 'required',
            'house_rent' => 'required',
            'medical_allowance' => 'required',
            'travel_allowance' => 'required',
            'food_allowance' => 'required',
        ]);
        $grade->basic_salary = $request->basic_salary;
        $grade->yearly_increment_rate = $request->yearly_increment_rate;
        $grade->house_rent = $request->house_rent;
        $grade->medical_allowance = $request->medical_allowance;
        $grade->travel_allowance = $request->travel_allowance;
        $grade->food_allowance = $request->food_allowance;
        $affected_row = $grade->save();
        if (!empty($affected_row)) {
            return redirect('/setting/employee_grades/')->with('message', 'Record Updated Successfully!');
        } else {
            return redirect('/setting/employee_grades/')->with('exception', 'Operation Failed!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaymentGrade  $paymentGrade
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentGrade $paymentGrade)
    {
        //
    }
}
