<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorageBlock extends Model
{
    protected $table='storage_blocks';
    protected $fillable=['storage_id','block_name','details','status','created_by','updated_by','company_id','branch_id'];


    public function selfOfBlocks(){ // self/rack into the Storage Every Block ----------
        return $this->hasMany(SelfOfStorageBlock::class,'storage_block_id','id');
    }

    public function storage(){
        return $this->belongsTo(Storage::class,'storage_id','id');
    }

}
