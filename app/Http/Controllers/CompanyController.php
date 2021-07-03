<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $data = Company::get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function(Company $company){
                        $editUrl = route('company.edit',$company->id);
                        $deleteUrl = route('company.destroy',$company->id);
                        $csrfFiled = csrf_field();
                        $methodFiled = method_field('DELETE');
                        $btn = '<a href="'.$editUrl.'" class="edit btn btn-primary btn-sm">Edit</a>&nbsp;<form action="'.$deleteUrl.'" method="POST">'.$csrfFiled.' '.$methodFiled.'<button class="btn btn-danger btn-sm" type="submit">Delete</button></form>';
                        return $btn;
                    })
                    ->addColumn('logo_name',function(Company $company){
                        if($company->logo && $company->logo!=""){
                            return '<img src = "'.asset('storage/').'/'.$company->logo.'" height="100" width="100" alt="logo"/>' ;
                        }
                        return '';
                    })
                    ->rawColumns(['action','logo_name'])
                    ->make(true);
        }
        return view('company.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('company.create');
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
        $validationArr['name'] = "required";
        if($request->email!=""){
            $validationArr['email'] = "email";
        }
        if($request->website!=""){
            $validationArr['website'] = "url";
        }
        if($request->has("logo")){
            $validationArr['logo'] = "image|dimensions:min_width=100,min_height=100";
        }
        $request->validate($validationArr);

        $company = new Company();
        $company->name = $request->name;
        $company->email = $request->email;
        $company->website = $request->website;

        if($request->has("logo")){
            $fileName = time().'.'.$request->logo->extension();  
            $response = Storage::disk('public')->put($fileName, File::get($request->logo));
            $company->logo = $fileName;
        }
        $company->save();
        return redirect('/company');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::find($id); 
        return view('company.edit',compact('company'));
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
        $validationArr = [];
        $validationArr['name'] = "required";
        if($request->email!=""){
            $validationArr['email'] = "email";
        }
        if($request->website!=""){
            $validationArr['website'] = "url";
        }
        if($request->has("logo")){
            $validationArr['logo'] = "image|dimensions:min_width=100,min_height=100";
        }
        $request->validate($validationArr);

        $company = Company::find($id);
        $company->name = $request->name;
        $company->email = $request->email;
        $company->website = $request->website;

        if($request->has("logo")){
            $fileName = time().'.'.$request->logo->extension();  
            $response = Storage::disk('public')->put($fileName, File::get($request->logo));
            $company->logo = $fileName;
        }
        $company->save();
        return redirect('/company');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::find($id);
        $company->delete();
        return redirect('/company');
    }
}
