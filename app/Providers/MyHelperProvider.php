<?php

namespace App\Providers;

use App\Models\CompanyList;
use App\Models\PrimaryInfo;
use Illuminate\Support\ServiceProvider;
use Image;

class MyHelperProvider extends ServiceProvider
{

    static public function slugify($text){
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        // transliterate
        //$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // trim
        $text = trim($text, '-');
        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);
        // lowercase
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }
    /* Convert in word taka */
    static public function taka($number)
    {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'one', 2 => 'two',
            3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
        $digits = array('', 'hundred','thousand','lakh', 'crore');
        while( $i < $digits_length ) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? $Rupees . ' Only ' : '');
    }

    static public function company(){
        if(\Auth::user()->isRole('super-admin')){
            return PrimaryInfo::first();
        }
        if(\Auth::user()->company_id!=null){
            return CompanyList::findOrFail(\Auth::user()->company_id);
        }else{
            return PrimaryInfo::first();
        }

    }
    static public function info(){
        return PrimaryInfo::first();
    }
    static public function companyId(){
            return \Auth::user()->company_id;
    }

    static public function photoUpload($photoData,$folderName){

        $fileType = $photoData->getClientOriginalExtension();
        $fileName = rand(1, 1000) . date('dmyhis') . "." . $fileType;
        $path2 = $folderName. date('Y/m/d');
        //return $path2;
        if (!is_dir($path2)) {
            mkdir("$path2", 0777, true);
        }
        $img = \Image::make($photoData);
        //$img->resize(400, 330);
        $img->save($folderName. date('Y/m/d/') . $fileName);
        return $photoUploadedPath=$folderName . date('Y/m/d/') . $fileName;

    }
    static public function hrmConfig(){
        $data = [
            'in_time'=>'09:00 AM',
            'out_time'=>'06:00 PM',
            'off_days'=>'Friday,Saturday',
        ];
        return $config = (object) $data;
    }

}
