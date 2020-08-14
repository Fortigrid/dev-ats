<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use DB;
use App\BusinessUnit;
use App\JobTemplate;
use Illuminate\Support\Facades\Auth;
use Validator;

class JobTemplateController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $business_ids= BusinessUnit::where('active','1')->get()->toArray();
		$jobtemplates=JobTemplate::select([
		'job_templates.id',
		'business_units.business_unit',
		'job_templates.template_name'
		])->join('business_units', 'business_units.id', '=', 'job_templates.business_unit_id')
		->where('job_templates.active',1);
	    if($request->ajax())
		{
			return DataTables::of($jobtemplates)
					->addColumn('action', function($jobtemplates){
						$button ='<button type="button"
						name="edit" id="'.$jobtemplates->id.'"
						class="edit btn btn-primary btn-sm edit
						"><img src="../css/img/edit-icon.png" /></button> ';
						$button .=' <button type="button"
						name="delete" id="'.$jobtemplates->id.'"
						class="delete btn btn-danger btn-sm delete
						"><img src="../css/img/remove-icon.png" /></button>';
						return $button;
					})
					->rawColumns(['action'])
					->make(true);
		}
		return view('job_templates',compact('business_ids'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		if($request->id ==''){
		$validator = Validator::make($request->all(), [
		'business_unit_id'=> 'required',
		'template_name'=> 'required|regex:/^[a-zA-Z ]+$/|min:3|max:50|unique:job_templates,template_name,'.$request->id,
		'header_image'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		'footer_image'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		
		]);
		} else {
			$validator = Validator::make($request->all(), [
		'business_unit_id'=> 'required',
		'template_name'=> 'required|unique:job_templates,template_name,'.$request->id
		
		
		]);
			
		}
		
		if ($validator->passes()) {
		  
			if($request->id ==''){
				$input = $request->all();

				$imageName = 'header'.time().'.'.request()->header_image->getClientOriginalExtension();
				$input['header_image'] = $imageName;
				request()->header_image->move(storage_path('app/public/uploads'), $imageName);
			 
				$imageNames = 'footer'.time().'.'.request()->footer_image->getClientOriginalExtension();
				$input['footer_image'] = $imageNames;
				request()->footer_image->move(storage_path('app/public/uploads'), $imageNames);
			
				$input['created_by'] = Auth::user()->id;
				JobTemplate::create($input);
			}
			else{
				$values = $request->except('_token');
				if($request->header_image !=''){
					$imageName1 = 'header'.time().'.'.request()->header_image->getClientOriginalExtension();
			
					$values['header_image'] = $imageName1;
					request()->header_image->move(storage_path('app/public/uploads'), $imageName1);
				}
				if($request->footer_image !=''){
			 
					$imageNames1 = 'footer'.time().'.'.request()->footer_image->getClientOriginalExtension();
					$values['footer_image'] = $imageNames1;
					request()->footer_image->move(storage_path('app/public/uploads'), $imageNames1);
				}
            
			    
			     JobTemplate::where("id", $request->id)->update($values);
				 #JobTemplate::where([["business_unit_id", $request->business_unit_id],["template_name", $request->template_name],["content_bg_color",$request->content_bg_color],["status", $request->status]])->update(["id" => $request->id]);
			    
			}

            return Response()->json(["success"=>'updated']);
		  
        }
		return response()->json(['error'=>$validator->errors()->all()]);
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
        
		$lid=array();
        $JobTemplate = JobTemplate::find($id);
	   
        return response()->json($JobTemplate);
		
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      
       JobTemplate::where("id", $id)->update(["active" => 0]);
	   return response()->json(['success'=>'Agency deleted!']);
	
    }
}
