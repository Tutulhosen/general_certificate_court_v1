<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CdapUserManagementController;
use Illuminate\Support\Facades\Session;


class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['short_news'] = News::orderby('id', 'desc')->where('news_type', 1)->where('status', 1)->get();
        $data['big_news'] = News::orderby('id', 'desc')->where('news_type', 2)->where('status', 1)->get();
        // return $data;
        return view('publicHomeH')->with($data);
    }

    public function policy(){
        $data['short_news'] = News::orderby('id', 'desc')->where('news_type', 1)->where('status',1)->get();
        $data['big_news'] = News::orderby('id', 'desc')->where('news_type', 2)->where('status',1)->get();
        // return $data;
        return view('policy')->with($data); 
    }

    public function show_log_in_page(Request $request)
    {
        // $cookie_doptor=$request->cookie('_ndortor');
        // if(isset($cookie_doptor))
        // {
        //     Cookie::queue(Cookie::forget('_ndortor'));
        // }
        $data['short_news'] = News::orderby('id', 'desc')->where('news_type', 1)->where('status', 1)->get();
        $data['big_news'] = News::orderby('id', 'desc')->where('news_type', 2)->where('status', 1)->get();
        // return $data;
        return view('login')->with($data);
    }

    public function process_map_view()
    {
        $data['short_news'] = News::orderby('id', 'desc')->where('news_type', 1)->where('status', 1)->get();
        $data['big_news'] = News::orderby('id', 'desc')->where('news_type', 2)->where('status', 1)->get();
        return view('process_map_view')->with($data);
    }

    public function cprc_home_page()
    {

        return view('crpc_home_page_details');
    }

    public function logout()
    {
        
        if( Auth::check())
        {
            if(!empty(globalUserInfo()->is_cdap_user) &&  globalUserInfo()->is_cdap_user == 1)
            {
                CdapUserManagementController::logout();
                Session::forget('modal_shown');
            }
            if(!empty(globalUserInfo()->doptor_user_flag) &&  globalUserInfo()->doptor_user_flag == 1)
            {
                
                Auth::logout();
                Session::forget('modal_shown');
                $callbackurl = url('/');
                $zoom_join_url = DOPTOR_ENDPOINT().'/logout?' . 'referer=' . base64_encode($callbackurl);
                return redirect()->away($zoom_join_url);
            }
        }
        
        Auth::logout();
        Session::forget('modal_shown');
        return redirect()->route('home');
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

    public function crawling()
    {
        $data['short_news'] = News::orderby('id', 'desc')->where('news_type', 1)->where('status', 1)->get();
        $data['big_news'] = News::orderby('id', 'desc')->where('news_type', 2)->where('status', 1)->get();
        $data['link']=mygov_endpoint().'/profile';   
        return view('cdap_nid_error')->with($data);
    }
    public function email_error()
    {
        $data['short_news'] = News::orderby('id', 'desc')->where('news_type', 1)->where('status', 1)->get();
        $data['big_news'] = News::orderby('id', 'desc')->where('news_type', 2)->where('status', 1)->get();
        $data['link']=mygov_endpoint().'/profile';   
        return view('cdap_email_error')->with($data);
    }
    
    
    
}
