<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SelfOfStorageBlock extends Model
{
    protected $table='self_of_storage_blocks';
    protected $fillable=['storage_block_id','self_of_block','status'];
}
