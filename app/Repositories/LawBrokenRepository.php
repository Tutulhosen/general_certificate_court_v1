<?php
/**
 * Created by PhpStorm.
 * User: destructor
 * Date: 11/29/2017
 * Time: 9:51 PM
 */
namespace App\Repositories;

use App\Appeal;

use App\Models\LawBroken;
use App\Services\AdminAppServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class LawBrokenRepository
{
    public static function storeLawsBroken($appealId,$lawsBrokenList){
        self::destroyLawsBroken($appealId);
        foreach ($lawsBrokenList as $reqLawsBroken){
            $section=AdminAppServices::getSectionBySectionId($reqLawsBroken['section_id']);
            $lawsBroken=new LawBroken();
            $lawsBroken->law_id=$reqLawsBroken['law_id'];
            $lawsBroken->law_title=AdminAppServices::getLawBylawId($reqLawsBroken['law_id'])->title;
            $lawsBroken->section_id=$reqLawsBroken['section_id'];
            $lawsBroken->section_title=$section->sec_title;
            $lawsBroken->law_section_title=$section->sec_title.' এর '.$section->punishment_sec_number.' ধারা';
            $lawsBroken->appeal_id=$appealId;
            $lawsBroken->created_at=date('Y-m-d H:i:s');
            $lawsBroken->created_by=Session::get('userInfo')->username;
            $lawsBroken->updated_at=date('Y-m-d H:i:s');
            $lawsBroken->updated_by=Session::get('userInfo')->username;
            $lawsBroken->save();
        }

    }
    public static function destroyLawsBroken($appealId){
        $lawsBroken = LawBroken::where('appeal_id',$appealId);
        $lawsBroken->delete();
        return;
    }




}