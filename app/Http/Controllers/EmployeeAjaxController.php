<?php
namespace App\Http\Controllers;

use App\Http\Middleware\CheckAge;
use App\Models\Employee;
use Illuminate\Http\Request;
use \Yajra\Datatables\Datatables;          
class EmployeeAjaxController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     
        if ($request->ajax()) {
  
            $data = Employee::latest()->get();
  
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editEmployee">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteEmployee">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('employeeAjax');
    }
       
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       
        Employee::updateOrCreate([
                    'id' => $request->id
                ],
                [
                    'first_name' => $request->first_name, 
                    'last_name' => $request->last_name,
                    'policy_no' => $request->policy_no,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'primium' => $request->primium,
                    'update_at' => $request->update_at,
                    'created_at' => $request->created_at
                ]);        
     
        return response()->json(['success'=>'Employee saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $Employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::find($id);
        return response()->json($employee);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $Employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Employee::find($id)->delete();
      
        return response()->json(['success'=>'Employee deleted successfully.']);
    }
}

?>