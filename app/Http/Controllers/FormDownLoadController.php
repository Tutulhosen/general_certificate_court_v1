<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormDownLoadController extends Controller
{
    public function index()
    {
        if(globalUserInfo()->role_id == 35 || globalUserInfo()->role_id == 36)
        {
             
             $data['page_title'] = 'ফর্ম ডাউনলোড';
             $data['downloadable_files']=[
                [
                    'file_name'=>'দায় অস্বীকার',
                    'file_location'=>url('').'/download_template/'.'defaulter_disagree_format.docx'
                ],
                [
                    'file_name'=>'সম্পত্তি নিলামে বিক্রি',
                    'file_location'=>url('').'/download_template/'.'crock.docx'
                ]                
             ];
             return view('form_download.citizen_form_download')->with($data);
        }else
        {
            $data['page_title'] = 'ফর্ম ডাউনলোড';
            $data['downloadable_files']=[
                [
                    'file_name'=>'দায় অস্বীকার',
                    'file_location'=>url('').'/download_template/'.'defaulter_disagree_format.docx'
                ],
                [
                    'file_name'=>'সম্পত্তি নিলামে বিক্রি',
                    'file_location'=>url('').'/download_template/'.'crock.docx'
                ]                
             ];
            return view('form_download.form_download')->with($data);
        }
        
    }
    public function usermanual(){
        $data['page_title'] = 'নির্দেশিকা';
        $data['roleID']= globalUserInfo()->role_id;

        if(globalUserInfo()->role_id ==2){

            $data['downloadable_files']=[
                [
                    'file_name'=>'এডমিন নির্দেশিকা',
                    'file_location'=>url('').'/download_usermanual/'.'1GCC_এডমিন_নির্দেশিকা.pdf'
                ],               
             ];
            
        }elseif(globalUserInfo()->role_id ==6){
           
            $data['downloadable_files']=[
                [
                    'file_name'=>'জেলা প্রশাসক নির্দেশিকা',
                    'file_location'=>url('').'/download_usermanual/'.'5_GCC_জেলা_প্রশাসক_নির্দেশিকা.pdf'
                ],               
             ];
        }elseif(globalUserInfo()->role_id ==7){
            $data['downloadable_files']=[
                [
                    'file_name'=>'অতিরিক্ত জেলা প্রশাসক (রাজস্ব) নির্দেশিকা',
                    'file_location'=>url('').'/download_usermanual/'.'6_GCC_অতিরিক্ত জেলা প্রশাসক_(রাজস্ব)_নির্দেশিকা.pdf'
                ],               
             ];
        }elseif(globalUserInfo()->role_id ==8){

            $data['downloadable_files']=[
                [
                    'file_name'=>'মন্ত্রিপরিষদ বিভাগের কার্যক্রম বিষয়ক নির্দেশিকা',
                    'file_location'=>url('').'/download_usermanual/'.'2_GCC_মন্ত্রিপরিষদ_বিভাগের_কার্যক্রম_বিষয়ক_নির্দেশিকা.pdf'
                ],               
             ];
           
        }elseif(globalUserInfo()->role_id ==14){

        }elseif(globalUserInfo()->role_id ==25){
            $data['downloadable_files']=[
                [
                    'file_name'=>'ভূমি আপীল বোর্ড চেয়ারম্যানের নির্দেশিকা',
                    'file_location'=>url('').'/download_usermanual/'.'3_GCC_ভূমি_আপীল_বোর্ড_চেয়ারম্যানের_নির্দেশিকা.pdf'
                ],               
             ];
        }elseif(globalUserInfo()->role_id ==27){
            $data['downloadable_files']=[
                [
                    'file_name'=>'জেনারেল সার্টিফিকেট অফিসারের নির্দেশিকা',
                    'file_location'=>url('').'/download_usermanual/'.'7_GCC_জেনারেল_সার্টিফিকেট_অফিসারের_নির্দেশিকা.pdf'
                ],               
             ];
        }elseif(globalUserInfo()->role_id ==28){

            $data['downloadable_files']=[
                [
                    'file_name'=>'সার্টিফিকেট সহকারী নির্দেশিকা',
                    'file_location'=>url('').'/download_usermanual/'.'8_GCC_সার্টিফিকেট_সহকারী_নির্দেশিকা.pdf'
                ],               
             ];


        }elseif(globalUserInfo()->role_id == 34){

            $data['downloadable_files']=[
               [
                   'file_name'=>'বিভাগীয় কমিশনার নির্দেশিকা',
                   'file_location'=>url('').'/download_usermanual/'.'4_GCC_বিভাগীয়_কমিশনার_নির্দেশিকা.pdf'
               ],              
            ];

            //dd($data);
       }elseif(globalUserInfo()->role_id == 35){

             $data['downloadable_files']=[
                [
                    'file_name'=>'নাগরিক,প্রাতিষ্ঠানিক প্রতিনিধির নিবন্ধন নির্দেশিকা',
                    'file_location'=>url('').'/download_usermanual/'.'9_GCC_নাগরিক,প্রাতিষ্ঠানিক_প্রতিনিধি_নিবন্ধন_নির্দেশিকা.pdf'
                ],
                [
                    'file_name'=>'প্রাতিষ্ঠানিক প্রতিনিধির রিকুইজিশন দাখিলের নির্দেশিকা',
                    'file_location'=>url('').'/download_usermanual/'.'10_GCC_প্রাতিষ্ঠানিক_প্রতিনিধির_রিকুইজিশান_দাখিলের_নির্দেশিকা.pdf'
                ]                
             ];

             //dd($data);
        }else{
           
        }
        return view('form_download.citizen_form_download')->with($data);
    }
}