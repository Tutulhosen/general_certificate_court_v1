<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class SiteSettingController extends Controller
{
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SiteSetting  $SiteSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(SiteSetting $SiteSetting)
    {
        $SiteSetting = SiteSetting::first();

        return view('setting.edit', compact('SiteSetting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SiteSetting  $SiteSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'copyright' => 'required',
        ]);

        $SiteSetting = SiteSetting::first();
        $SiteSetting->update($request->all());

        if($request->hasFile('site_logo')){
            $image = $request->site_logo;
            $image_new_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move('storage/SiteSetting/', $image_new_name);
            $SiteSetting->site_logo = '/storage/SiteSetting/' . $image_new_name;
            $SiteSetting->save();
        }
        if($request->hasFile('footer_logo')){
            $image = $request->footer_logo;
            $image_new_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move('storage/SiteSetting/', $image_new_name);
            $SiteSetting->footer_logo = '/storage/SiteSetting/' . $image_new_name;
            $SiteSetting->save();
        }
        if($request->hasFile('fevicon')){
            $image = $request->fevicon;
            $image_new_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move('storage/SiteSetting/', $image_new_name);
            $SiteSetting->fevicon = '/storage/SiteSetting/' . $image_new_name;
            $SiteSetting->save();
        }

        Session::flash('success', 'SiteSetting updated successfully');
        return redirect()->back();
    }
}
