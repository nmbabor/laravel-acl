<?php

namespace App\Http\Controllers\Hrm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendanceReciveController extends Controller
{
    public function getAttendance(Request $request){
        $data = $request->all();
        echo "<h4>Received Data by get request : </h4><br>";
        print_r($data);
    }
    public function postAttendance(Request $request){
        $data = $request->all();
        echo "<h4>Received Data by post request : </h4><br>";
        print_r($data);
    }
}
