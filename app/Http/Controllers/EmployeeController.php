<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Employee;
use App\Company;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if($request->ajax()) {
            $empolyee = Employee::get();
            return Datatables::of($empolyee)
                    ->addIndexColumn()
                    ->addColumn('company_name',function(Employee $empolyee){
                        return $empolyee->company->name;
                    })
                    ->addColumn('action', function(Employee $empolyee){
                        $editUrl = route('employee.edit',$empolyee->id);
                        $deleteUrl = route('employee.destroy',$empolyee->id);
                        $csrfFiled = csrf_field();
                        $methodFiled = method_field('DELETE');
                        $btn = '<a href="'.$editUrl.'" class="edit btn btn-primary btn-sm">Edit</a>&nbsp;<form action="'.$deleteUrl.'" method="POST">'.$csrfFiled.' '.$methodFiled.'<button class="btn btn-danger btn-sm">Delete</button></form>';
                        return $btn;
                    })
                    ->rawColumns(['action','company_name'])
                    ->make(true);
        }
        return view('employee.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $compaines = Company::get();
        return view('employee.create',compact('compaines'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validationArr = [];
        $validationArr['first_name'] = "required";
        $validationArr['last_name'] = "required";
        if($request->email!=""){
            $validationArr['email'] = "email";
        }
        if($request->phone!=""){
            $validationArr['phone'] = "numeric|min:10";
        }
        $validationArr['company'] = "required";
        $request->validate($validationArr);
        $empolyee = new Employee();
        $empolyee->first_name = $request->first_name;
        $empolyee->last_name = $request->last_name;
        $empolyee->email = $request->email;
        $empolyee->phone = $request->phone;
        $empolyee->company_id = $request->company;
        $empolyee->save();
        return redirect('/employee');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $compaines  = Company::get();
        $employee = Employee::find($id);
        return view('employee.edit',compact('compaines','employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validationArr = [];
        $validationArr['first_name'] = "required";
        $validationArr['last_name'] = "required";
        if($request->email!=""){
            $validationArr['email'] = "email";
        }
        if($request->phone!=""){
            $validationArr['phone'] = "numeric|min:10";
        }
        $validationArr['company'] = "required";
        $request->validate($validationArr);
        $empolyee = Employee::find($id);
        $empolyee->first_name = $request->first_name;
        $empolyee->last_name = $request->last_name;
        $empolyee->email = $request->email;
        $empolyee->phone = $request->phone;
        $empolyee->company_id = $request->company;
        $empolyee->save();
        return redirect('/employee');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empolyee = Employee::find($id);
        $empolyee->delete();
        return redirect('/employee');
    }
}
