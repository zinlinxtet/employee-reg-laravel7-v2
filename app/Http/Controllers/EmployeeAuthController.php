<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\EmployeeAuthRequest;

/**
 * Create EmployeeAuthController for login and logout.
 * @author Zin Lin Htet
 * @created 21/6/2023
 */
class EmployeeAuthController extends Controller
{
    /**
     * When employee login, call this function with passing EmployeeAuthRequest and goto Index page
     * @author Zin Lin Htet
     * @create 21/6/2023
     * @param EmployeeAuthRequest $request
     * @return 'redirect'
     */
    public function login(EmployeeAuthRequest $request)
    {
        $employee = Employee::where('employee_id',$request->employee_id)->first();
        if($employee){
            if(Hash::check($request->password,$employee->password)){
                session()->put('employee',$employee);
                return redirect()->route('employees.index');
            }else{
                return redirect()->back()->withErrors(['error' => 'Employee ID and password are not match.']);
            }
        }else{
            return redirect()->back()->withErrors(['error' => 'Invalid employee ID or password.']);
        }

    }

    /**
     * When employee login, validation is not passed, call this function and goto Login page
     * @author Zin Lin Htet
     * @created 21/6/2023
     * @return 'view'
     */
    public function show()
    {
        return view('auth.login');
    }

    /**
     * When employee logout, call this function with passing Request
     * @author Zin Lin Htet
     * @created 21/6/2023
     * @param Request $request
     * @return 'redirect'

     */
    public function logout(Request $request)
    {
        // Clear the employee's session
        session()->forget('employee');

        // Redirect to the login page
        return redirect()->route('login.show');
    }

}
