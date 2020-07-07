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
        return view('administrator.setting.employee_grades.grades');
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
        //
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
    public function edit(PaymentGrade $paymentGrade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentGrade  $paymentGrade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentGrade $paymentGrade)
    {
        //
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
