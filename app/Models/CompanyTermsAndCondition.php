<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyTermsAndCondition extends Model
{
    protected $table='company_terms_and_conditions';
    protected $fillable=['condition_type','condition_title','condition_details','condition_status','created_by','updated_by'];
}
