<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(mobile_first_registration())
        {
            $data['short_news'] = News::orderby('id', 'desc')->where('news_type', 1)->where('status',1)->get();
            $data['big_news'] = News::orderby('id', 'desc')->where('news_type', 2)->where('status',1)->get();
            // return $data;
            return view('mobile_first_registration.registration')->with($data);
        }else
        {
            $data['short_news'] = News::orderby('id', 'desc')->where('news_type', 1)->where('status',1)->get();
            $data['big_news'] = News::orderby('id', 'desc')->where('news_type', 2)->where('status',1)->get();
            // return $data;
            return view('registration.registration')->with($data);
        }     
        
    }

   


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
