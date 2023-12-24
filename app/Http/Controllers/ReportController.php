<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transection;

class ReportController extends Controller
{
    //

    public function __construct(){
        $this->middleware("auth:api");
    }

    public function created_report(Request $request){

        $month_type = $request->month_type;
        $dmy = $request->dmy;

        $m = explode("-",$dmy)[1];
        $y = explode("-",$dmy)[0];

        $labels = [];
        $income = [];
        $expense = [];

        if ($month_type == 'm') {
            
           // ຊອກຫາວັນທີ່ສຸດທ້າຍຂອງເດຶອນ
           $last_day = date("t", strtotime($dmy));
        //    return $last_day;

        for ($i=1; $i <=$last_day ; $i++) { 
            array_push($labels, "ວັນທີ່" .$i);
        }

        return $labels;
           

        } elseif ($month_type == 'y') {
            
        }

        return array_reverse($tran);

    }

}
