<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyModule extends Model
{
    protected $table = 'company_modules';
    protected $fillable = ['module_id','company_id'];

    public function menu(){
      return $this->belongsTo(Menu::class,'module_id','id');
    }
}
