<?php

namespace App\Http\Controllers;

use App\Models\SelfOfStorageBlock;
use App\Models\Storage;
use App\Models\StorageBlock;
use App\Models\CompanyBranch;
use Illuminate\Http\Request;
use Auth;
use Validator;
use DB;
use Yajra\DataTables\DataTables;

class StorageBlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('primaryInfo.company.storage.block.index',compact('binLocations'));

    }

    public function showAllStorageBlocks(){
        $storageBlocks=StorageBlock::leftjoin('storages','storage_blocks.storage_id','storages.id')
              ->select('storages.storage_name','storage_blocks.*');

        return DataTables::of($storageBlocks)
            ->addColumn('action',' {!!Form::open(array(\'route\'=>[\'storage-block.destroy\',"$id"],\'method\'=>\'DELETE\',\'id\'=>"deleteForm$id"))!!}
                <a href="{{URL::to("storage-block/$id/")}}" title=\'Click here to view all info \' class="btn btn-info btn-xs" target="_blank"> <i class="fa fa-eye"></i></a>
                <a href="{{URL::to("storage-block/$id/edit")}}" title=\'Click here to edit \' class="btn btn-warning btn-xs"> <i class="fa fa-pencil-square"></i></a>
                <button type="button" class="btn btn-danger btn-xs" onclick="return deleteConfirm(\'deleteForm{{ $id}}\')"><i class="fa fa-trash"></i></button>
           {!! Form::close() !!}')
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $storages=Storage::orderBy('id','desc')->where('status',1)->pluck('storage_name','id');
        return view('primaryInfo.company.storage.block.create',compact('storages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'storage_id' => 'required',
            'block_name' => 'required|unique:storage_blocks,block_name',
            'self_of_block' => 'required',

        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $input = $request->except('_token');
        $input['created_by']=Auth::user()->id;

        $storageInfo=Storage::findOrFail($request->storage_id);
        if (!empty($storageInfo)){
            $input['company_id']=$storageInfo->company_id;
            $input['branch_id']=$storageInfo->branch_id;
        }

        DB::beginTransaction();
        try {
            // Create Storage Block ------------------
            $lastInsertId=StorageBlock::create($input)->id;

            // Create self/rack on Storage Block ------------
            if (isset($request->self_of_block)){
                $selfOfBlocks=explode(',',$request->self_of_block);
                foreach ($selfOfBlocks as $selfOfBlock){
                    SelfOfStorageBlock::create([
                        'storage_block_id'=>$lastInsertId,
                        'self_of_block'=>$selfOfBlock,
                        'created_by'=>Auth::user()->id
                    ]);
                }
            }


            $bug=0;
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','New Block Of Storage Created Successfully.');
        }else{
            return redirect()->back()->with('error','Error: '.$bug1);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StorageBlock  $binLocation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $getStorageBlock=StorageBlock::findOrFail($id);
        return view('primaryInfo.company.storage.block.show',compact('getStorageBlock'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StorageBlock  $binLocation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $storages=Storage::orderBy('id','desc')->where('status',1)->pluck('storage_name','id');
        $getStorageBlock=StorageBlock::findOrFail($id);
        return view('primaryInfo.company.storage.block.edit',compact('storages','getStorageBlock'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StorageBlock  $binLocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'storage_id' => 'required',
            'block_name' => "required|unique:storage_blocks,block_name,$id",
            'self_of_block' => 'required',

        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $input = $request->except('_token');

        $getStorageBlock=StorageBlock::findOrFail($id);
        $input['updated_by']=Auth::user()->id;
        $storageInfo=Storage::findOrFail($request->storage_id);

        if (!empty($storageInfo)){
            $input['company_id']=$storageInfo->company_id;
            $input['branch_id']=$storageInfo->branch_id;
        }

        DB::beginTransaction();
        try {
            // update Storage Block ------------------
            $getStorageBlock->update($input);

            // Create self/rack on Storage Block ------------
            if (isset($request->self_of_block)){

                 $odlDatas=SelfOfStorageBlock::where('storage_block_id',$id)->get();
                 $newDatas=explode(',',$request->self_of_block);


                  foreach ($odlDatas as $old_key=>$odlData){

                      foreach ($newDatas as $new_key=>$newData){
                          if ($odlData->self_of_block==$newData){
                            unset($odlDatas[$old_key]);
                            unset($newDatas[$new_key]);
                          }

                      }

                  }


                  // delete from odl data ------------
                if (count($odlDatas)>0){
                      foreach ($odlDatas as $odlData){
                          SelfOfStorageBlock::where('id',$odlData->id)->delete();
                      }

                }

                   // insert new self/rack data -----------------------
               if (count($newDatas)>0){
                   foreach ($newDatas as $selfOfBlock){
                       SelfOfStorageBlock::create([
                           'storage_block_id'=>$id,
                           'self_of_block'=>$selfOfBlock,
                           'created_by'=>Auth::user()->id
                       ]);
                   }
               }
            }


            $bug=0;
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','New Block Of Storage Created Successfully.');
        }else{
            return redirect()->back()->with('error','Error: '.$bug1);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StorageBlock  $binLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $getStorageBlockById=StorageBlock::findOrFail($id);
        DB::beginTransaction();
        try {
            SelfOfStorageBlock::whereIn('storage_block_id',[$getStorageBlockById->id])->delete();

            $getStorageBlockById->delete();
            $bug = 0;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','Old Bin location Info Delete Successfully.');
        }elseif ($bug==547){
            return redirect()->back()->with('error','Sorry, This data already used another module');
        }
        else{
            return redirect()->back()->with('error','Error: '.$bug1);
        }
    }
}
