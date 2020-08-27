<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Traits\ApiResponser;
use Fouladgar\EloquentBuilder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\File;

use Illuminate\Http\UploadedFile;
class EmployeeController extends Controller
{
    use ApiResponser;    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //
    /**
     * Return Employees list
     *
     * @return  Illuminate\Http\Response
     */
    public function index(){
        $employees = Employee::all();
        return $this->successResponse($employees);
    }

    /**
     * Return Employees list for parameter
     *
     * @return  Illuminate\Http\Response
     */
  
     public function search(Request $request){
        $total = Employee::all()->count();
        $rules = [
            'page'  =>'integer|min:1', 
            'limit' =>"integer|min:1|max:$total",
        ];
        $this->validate($request,$rules);
            
        if($request->has('quest')){
            $query = $request->quest;
            $quantity_found = Employee::where('names', 'LIKE', "%$query%")
                                        ->orWhere('surname', 'LIKE', "%$query%")
                                        ->orWhere('dni', 'LIKE', "%$query%")
                                        ->count();
            if($quantity_found != 0){
                $page_max = ceil($quantity_found/$request->limit);
                $this->validate($request,['page'  =>"integer|max:$page_max"]);
            }
            
            
            $employee = Employee::where('names', 'LIKE', "%$query%")
                                ->orWhere('surname', 'LIKE', "%$query%")
                                ->orWhere('dni', 'LIKE', "%$query%")
                                ->paginate($request->limit); 

        }else{
            $page_max = ceil($total/$request->limit);
            $this->validate($request,['page'  => "integer|max:$page_max"]);
            $employee = Employee::paginate($request->limit); 
        }

        $employee->current_page = $request->page;
        return $this->successResponse($employee);
         
    }


    /**
     * Return Employees list for filter
     *
     * @return  Illuminate\Http\Response
     */
    public function searchFilter(Request $request){
        
       
        //$users = EloquentBuilder::to(Employee::class, $request->all());

        //return $users->get();
        /*if($request->has('names')){
            $query = $request->names;
            $employee  = Employee::all();
            $employee->where('names','LIKE', "%$query%");   
                               
        }

        if($request->has('surname')){
            $query = $request->surname;
            $employee = $employee->merge($employee->where('surname', 'LIKE', "%$query%"));        
        }

        if($request->has('dni')){
            $query = $request->names;
            $employeeD = Employee::where('dni', 'LIKE', "%$query%");
                        //->paginate($request->limit);
            $employee = $employeeD->merge();         
        }*/
        //$employee = $employee->all();
        $employee = Employee::all();

        if ($request->has('names')) {
            $employee->where('name', 'LIKE', $request->names);
        }

        if ($request->has('surname')) {
            $employee->where('surname','LIKE', $request->surname);
        }

        return $this->successResponse($employee);
         
    }
    /**
     * Create an instance of Employee
     *
     * @return  Illuminate\Http\Response
     */

    public function store(Request $request){
        //validation 
        $rules = [
            'dni' =>'numeric|required|unique:employees|digits:8', 
            'code' =>'string|nullable|unique:employees', 
            'names' =>'string|required|max:50', 
            'surname' =>'string|required|max:50',
            'profile_id' =>'integer|required|min:1', 
            'date_of_birth' =>'string|nullable',
            'gender' =>'string|nullable|in:M,F',  
            'phone' =>'integer|nullable|digits_between:7,10', 
            'mobile' =>'integer|nullable|digits:9', 
            'address' =>'string|nullable', 
            'email' =>'string|nullable|unique:employees', 
            'photo' => 'nullable|image'
        ];

        $this->validate($request,$rules);

        //upload photo
        $urlPhotoName = ($request->file('photo')!=null)?time().$request->file('photo')->getClientOriginalName():null;
       
        if($urlPhotoName!=null){
            Storage::disk('localEmployees')->put($urlPhotoName,File::get($request->file('photo')));
            $urlPhotoName = url("/")."/img/employees/".$urlPhotoName;
        }
            
            
        
        //guardar en la BD
        $employee = Employee::create([
            'dni' => $request->dni, 
            'code'=> $request->code, 
            'names'=> $request->names, 
            'surname'=> $request->surname, 
            'profile_id'=> $request->profile_id, 
            'date_of_birth'=> $request->date_of_birth, 
            'phone'=> $request->phone, 
            'mobile'=> $request->mobile, 
            'gender'=> $request->gender, 
            'address'=> $request->address, 
            'email'=> $request->email, 
            'photo'=> $urlPhotoName, 
        ]);
        //respuesta
        return $this->successResponse($employee, Response::HTTP_CREATED);
     }

     /**
     * Return an specific author
     *
     * @return  Illuminate\Http\Response
     */

    public function show($id){

        $employee = Employee::findOrFail($id);

        return $this->successResponse($employee);

    }

    /**
     * Update the information of an existing Employee
     *
     * @return  Illuminate\Http\Response
     */

    public function update(Request $request, $id){
        //find employee
        $employee = Employee::findOrFail($id);
        //rules
        $rules = [
            'dni' =>"numeric|unique:employees,dni,$id|digits:8", 
            'code' => "unique:employees,code,$id|nullable",
            'profile_id' =>'required_with:profile|integer|min:1', 
            'date_of_birth' =>'string|nullable', 
            'phone' =>'numeric|nullable|digits_between:7,10', 
            'gender' =>'string|nullable|in:F,M', 
            'mobile' => 'string|nullable',
            'address' =>'string|nullable', 
            'email' =>'email|nullable', 
            'photo' => 'image|nullable',
        ];
        
        $this->validate($request,$rules);
        //update photo
        if($request->file('photo')!=null){
            $urlPhotoName = time().$request->file('photo')->getClientOriginalName();
            Storage::disk('localEmployees')->put($urlPhotoName,File::get($request->file('photo')));
            $urlPhotoName = url("/")."/img/employees/".time().$request->file('photo')->getClientOriginalName();
            //delele photo
            $array = explode("/",$employee->photo);
            $index = count($array);
            $image_to_delete = $array[$index-1];
            Storage::disk('localEmployees')->delete($image_to_delete);
            
        }else{
            $urlPhotoName = $employee->photo;
        }
        
        $employee->fill($request->except(['photo']));
        $employee->fill(['photo' => $urlPhotoName]);

        if($employee->isClean()){
            return $this->errorResponse('At least one value must change',
            Response::HTTP_UNPROCESSABLE_ENTITY, 'E002');
        }

        $employee->save();

        return $this->successResponse($employee, Response::HTTP_CREATED);

    }

    /**
     * Removes an existing Employee
     *
     * @return  Illuminate\Http\Response
     */

    public function destroy($id){
        $employee = Employee::findOrFail($id);

        $employee->delete();

        return $this->successResponse($employee);

    }

    /**
     * Return Employees list paginatation
     *
     * @return  Illuminate\Http\Response
     */
    public function pagination(Request $request){
        $total = Employee::all()->count();

        $rules = [
            'page'  =>'integer|min:1', 
            'limit' =>"integer|min:1|max:$total",
        ];

        $this->validate($request,$rules);
        
        $page_max = ceil($total/$request->limit);

        $this->validate($request,['page'  => "integer|max:$page_max"]);
        
        $employee = Employee::paginate($request->limit); 
    
        $employee->current_page = $request->page;
        return $this->successResponse($employee);
         
    }

    


    //
}
