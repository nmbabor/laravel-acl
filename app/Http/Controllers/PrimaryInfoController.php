<?php

namespace App\Http\Controllers;

use App\Models\CompanyList;
use App\Models\Menu;
use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use App\Models\PrimaryInfo;

class PrimaryInfoController extends Controller
{

    /**
     * Display Video Section Information.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=PrimaryInfo::first();
        $allCompany = CompanyList::orderBy('id','DESC')->paginate(20);
        $modules = Menu::where('status',1)->where('type',1)->pluck('name','id');
        return view('primaryInfo.primaryInfo',compact('data','allCompany','modules'));
    }

    /**
     * Show Section Contact photo.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Change Video section information, contact section photo and body parallax Background
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display Body Parallax Photo background.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data=PrimaryInfo::first();
        return view('primaryInfo.about',compact('data'));
    }

    /**
     * Show Organization primary information.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Display About Company.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update Primary info and about company.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $data=PrimaryInfo::findOrFail($request->id);

        $validator = Validator::make($input, [

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($request->hasFile('logo')) {
            $photo=$request->file('logo');
            $path=base_path().'/images/logo';
            if (!is_dir($path)) {
                mkdir("$path",0777,true);
            }
            $img=\Image::make($photo);
            $img->resize(180, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save('images/logo/logo.png');
            $input['logo']='images/logo/logo.png';
        }
        if ($request->hasFile('favicon')) {
            $photo=$request->file('favicon');
            $path=base_path().'/images/logo';
            if (!is_dir($path)) {
                mkdir("$path",0777,true);
            }
            $img=\Image::make($photo)->resize(50,50);
            $img->save('images/logo/favicon.png');
            $input['favicon']='images/logo/favicon.png';
        }

        try{
            $data->update($input);

            $bug=0;
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }
        if($bug==0){
            return redirect()->back()->with('success','Successfully Update');
        }else{
            return redirect()->back()->with('error','Something Error Found ! ');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
