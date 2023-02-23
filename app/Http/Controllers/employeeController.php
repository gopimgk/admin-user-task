<?php

namespace App\Http\Controllers;
//use Request;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Request;
use App\Models\userdata;
use App\Models\Employees;
use App\Http\Models\Admindata;
use App\Models\Empdata;
use Illuminate\Support\Facades\Redirect;
// use Validator;
use Response;
 //use Illuminate\Http\Response;
// use Illuminate\Http\Request;


class employeeController extends Controller
{
	public function index(){
		return view('login');
	}
	//check login details from database
	public function checklogin(Request $req){
		$validator=$req->validate([
            'username' => 'required|alpha|max:10',
            'password' => 'required|min:8',
        ]);
		$data=userdata::select('*')->where('username',$req->username)->where('password',$req->password)->get();
		if(count($data)!=0){
			$req->session()->put('name',$req->username);
			$req->session()->put('role',$data[0]->Roll);
		if($data[0]->Roll=='admin'){
		  return  view('employeecreate');
			}
			else
			{
			$data=Employees::select('*')->where('EmployeeId',$data[0]->EmployeeId)->get();

		  return  view('userdashboard')->with('data',$data);
	}}
	else{
		return back()->with('message', 'please enter currect details.');
		}
	}

	//logout function
	public function logout(Request $req){
		$req->session()->forget('name');
		$req->session()->forget('role');
		return view('login');
	}

	//employee create form data storein databade
	public function empcreate(Request $req){
		$validator=$req->validate([
            'id' => 'required|Numeric',
            'FirstName' => 'required|alpha|max:10',
            'LastName' => 'required|alpha|max:10',
            'skill'  => 'required',
            'StartDate'  => 'required',
        ]);
		$data=new Employees;
		$data->EmployeeId=$req->id;
		$data->FirstName= ucfirst($req->FirstName);
		$data->LastName=$req->LastName;
		$data->Skills=json_encode($req->skill);
		$data->StartDate=$req->StartDate;
		$data->createdBy=session()->get('name');
		$data->updatedBy=session()->get('name');
		$data->save();
		$data1=Employees::select('*')->get();
		return view('employeelist')->with('data',$data1);
	}

	//employee list display in admin dashboard
	public function emplist(Request $req){
		//dd($req->session()->get('name'));
		if(session()->get('role')=='admin'){
			$data=Employees::select('*')->get();
			return view('employeelist')->with('data',$data);
		}
		else{
			return view('login');
		}
	}

	//in admin update drapdown employee names
	public function updateemp(){
		$data=Employees::select('FirstName')->get();
	return view('updateemp')->with('data',$data);
	}

	//edit data form database
	public function edit(Request $request){
		$data=Employees::select('*')->where('FirstName',$request->name)->get();
	        return response()->json($data);
	}

	//update data store in database
	public function empupdate(Request $request){
		// dd($request->id);
		$data=Employees::where('EmployeeId',$request->id)->first();
		$data->EmployeeId=$request->id;
		$data->FirstName=$request->FirstName;
		$data->LastName=$request->LastName;
		$data->Skills=json_encode($request->skill);
		$data->StartDate=$request->StartDate;
		$data->updatedBy=session()->get('name');
		$data->update();
		$data1=Employees::select('*')->get();
		return view('employeelist')->with('data',$data1);
	}

	public function nonUsers(Request $req){
		if(session()->get('role')=='admin')
		{
			$eid=userdata::pluck('EmployeeId');
			$data=Employees::whereNotIn('EmployeeId',$eid)->get();
			return view('nonUsers')->with('data',$data);
		}
		else{
			return view('login');
		}
	}
}
