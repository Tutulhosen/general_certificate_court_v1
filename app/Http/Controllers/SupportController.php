<?php

namespace App\Http\Controllers;

use ZipArchive;
use Illuminate\Http\Request;
use File;

class SupportController extends Controller
{
    public function support_form_page()
    {
        $data['page_title']='সাপোর্ট';
        
        return view('support.form')->with($data);
    }
    public function citizen_support_form_page()
    {
        $data['page_title']='সাপোর্ট';
        
        return view('support.citigen.form')->with($data);
    }
    
    public function support_form_page_no_auth()
    {
        $data['page_title']='সাপোর্ট';
        
        return view('support.no_auth.form')->with($data);
    }

    public function support_form_post_no_auth(Request $request)
    {
        //dd('d');

        $zip_attachments = [];

        $zip_attachments_wrapper = [];


        if (!empty($_FILES['file_name']['name'])) {
            $zip = new ZipArchive();
            $upload_path = '/uploads/support/';

            $zip_name = getcwd() . "/uploads/support/upload_" . $request->support_email . ".zip";

            if ($zip->open($zip_name, ZipArchive::CREATE) !== true) {

            }
            $imageCount = count($_FILES['file_name']['name']);
            for ($i = 0; $i < $imageCount; $i++) {

                if ($_FILES['file_name']['tmp_name'][$i] == '') {
                    continue;
                }
                $newname = $_FILES['file_name']['type'][$i];

                // Moving files to zip.
                $zip->addFromString($_FILES['file_name']['name'][$i], file_get_contents($_FILES['file_name']['tmp_name'][$i]));

                // moving files to the target folder.

            }
            $zip->close();

            // Create HTML Link option to download zip
            $success = url('/') . '/uploads/support/' . basename($zip_name);

            $files = File::files('uploads/support');
            //dd($files[0]);

            // dd($files[0]->getContents());

            foreach ($files as $value) {
                if (str_contains($value->getFilenameWithoutExtension(), $request->support_email)) {
                    //echo($value->getFilenameWithoutExtension());
                    $api_string = "data:" . 'application/x-zip-compressed' . ';base64,' . base64_encode($value->getContents());

                    $zip_attachments[$value->getFilenameWithoutExtension() . '.zip'] = $api_string;

                    array_push($zip_attachments_wrapper, $zip_attachments);
                }
            }

        }

       

        $request->validate([
            'support_name' => 'required',
            'support_email' => 'required|email',
            'support_mobail' => 'required|size:11|regex:/(01)[0-9]{9}/',
            'support_subject' => 'required',
            'support_details' => 'required',
        ],
            [
                'support_name.required' => 'পুরো নাম লিখুন',
                'support_subject.required' => 'বিষয় দিতে হবে',
                'support_email.required' => 'আপনার ইমেইল লিখুন',
                'support_email.email' => 'সঠিক ইমেইল লিখুন',
                'support_mobail.required' => 'মোবাইল নং দিতে হবে',
                'support_mobail.size' => 'মোবাইল নং দিতে হবে 11 digit',
                'support_details.required' => 'বিস্তারিত দিতে হবে',

            ]);

       

        $config = array(
            'url' => 'http://localhost:8080/osTicket/upload/api/tickets.json',
            'key' => '760E2B4AB14BC82CF25499D0428A5128',
        );

        #pre-checks
        function_exists('curl_version') or die('CURL support required');

        #set timeout
        set_time_limit(1500);

        #Sample data for the ticket
        # See https://github.com/osTicket/osTicket-1.7/blob/develop/setup/doc/api/tickets.md for full list of variables and options that you can pass.
        $data = array("alert" => "true",
            "autorespond" => "true",
            "source" => "API",
            "name" => $request->support_name,
            "email" => $request->support_email,
            "phone" => $request->support_mobail,
            "subject" => $request->support_subject,
            "message" => $request->support_details,
            "attachments" => $zip_attachments_wrapper,
        );

        #Convert the above array into json to POST to the API with curl below.
        $data_string = json_encode($data);

       //  dd($data_string );

        #curl post
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $config['url']);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_USERAGENT, 'osTicket API Client v1.7');
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:', 'X-API-Key: ' . $config['key']));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        if (preg_match('/HTTP\/.* ([0-9]+) .*/', $result, $status) && $status[1] == 200) {
            exit(0);
        }
        else
        {
            return redirect()->back()->with('success','আপনার তথ্য Support টিমের কাছে পাঠানো হয়েছে সফলভাবে')->withInput();
        }
        //var_dump($result);
        exit(1);
    } 
    
    public function support_form_post(Request $request)
    {
        $zip_attachments = [];

        $zip_attachments_wrapper = [];


        if (!empty($_FILES['file_name']['name'])) {
            $zip = new ZipArchive();
            $upload_path = '/uploads/support/';

            $zip_name = getcwd() . "/uploads/support/upload_" . $request->support_email . ".zip";

            if ($zip->open($zip_name, ZipArchive::CREATE) !== true) {

            }
            $imageCount = count($_FILES['file_name']['name']);
            for ($i = 0; $i < $imageCount; $i++) {

                if ($_FILES['file_name']['tmp_name'][$i] == '') {
                    continue;
                }
                $newname = $_FILES['file_name']['type'][$i];

                // Moving files to zip.
                $zip->addFromString($_FILES['file_name']['name'][$i], file_get_contents($_FILES['file_name']['tmp_name'][$i]));

                // moving files to the target folder.

            }
            $zip->close();

            // Create HTML Link option to download zip
            $success = url('/') . '/uploads/support/' . basename($zip_name);

            $files = File::files('uploads/support');
            //dd($files[0]);

            // dd($files[0]->getContents());

            foreach ($files as $value) {
                if (str_contains($value->getFilenameWithoutExtension(), $request->support_email)) {
                    //echo($value->getFilenameWithoutExtension());
                    $api_string = "data:" . 'application/x-zip-compressed' . ';base64,' . base64_encode($value->getContents());

                    $zip_attachments[$value->getFilenameWithoutExtension() . '.zip'] = $api_string;

                    array_push($zip_attachments_wrapper, $zip_attachments);
                }
            }

        }

       

        $request->validate([
            'support_name' => 'required',
            'support_email' => 'required|email',
            'support_mobail' => 'required|size:11|regex:/(01)[0-9]{9}/',
            'support_subject' => 'required',
            'support_details' => 'required',
        ],
            [
                'support_name.required' => 'পুরো নাম লিখুন',
                'support_subject.required' => 'বিষয় দিতে হবে',
                'support_email.required' => 'আপনার ইমেইল লিখুন',
                'support_email.email' => 'সঠিক ইমেইল লিখুন',
                'support_mobail.required' => 'মোবাইল নং দিতে হবে',
                'support_mobail.size' => 'মোবাইল নং দিতে হবে 11 digit',
                'support_details.required' => 'বিস্তারিত দিতে হবে',

            ]);

       

        $config = array(
            'url' => 'http://localhost:8080/osTicket/upload/api/tickets.json',
            'key' => '760E2B4AB14BC82CF25499D0428A5128',
        );

        #pre-checks
        function_exists('curl_version') or die('CURL support required');

        #set timeout
        set_time_limit(1500);

        #Sample data for the ticket
        # See https://github.com/osTicket/osTicket-1.7/blob/develop/setup/doc/api/tickets.md for full list of variables and options that you can pass.
        $data = array("alert" => "true",
            "autorespond" => "true",
            "source" => "API",
            "name" => $request->support_name,
            "email" => $request->support_email,
            "phone" => $request->support_mobail,
            "subject" => $request->support_subject,
            "message" => $request->support_details,
            "attachments" => $zip_attachments_wrapper,
        );

        #Convert the above array into json to POST to the API with curl below.
        $data_string = json_encode($data);

       //  dd($data_string );

        #curl post
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $config['url']);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_USERAGENT, 'osTicket API Client v1.7');
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:', 'X-API-Key: ' . $config['key']));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        if (preg_match('/HTTP\/.* ([0-9]+) .*/', $result, $status) && $status[1] == 200) {
            exit(0);
        }
        else
        {
            return redirect()->back()->with('success','আপনার তথ্য Support টিমের কাছে পাঠানো হয়েছে সফলভাবে')->withInput();
        }
        //var_dump($result);
        exit(1);
    } 
    
    public function support_form_post_citizen(Request $request)
    {
        $zip_attachments = [];

        $zip_attachments_wrapper = [];


        if (!empty($_FILES['file_name']['name'])) {
            $zip = new ZipArchive();
            $upload_path = '/uploads/support/';

            $zip_name = getcwd() . "/uploads/support/upload_" . $request->support_email . ".zip";

            if ($zip->open($zip_name, ZipArchive::CREATE) !== true) {

            }
            $imageCount = count($_FILES['file_name']['name']);
            for ($i = 0; $i < $imageCount; $i++) {

                if ($_FILES['file_name']['tmp_name'][$i] == '') {
                    continue;
                }
                $newname = $_FILES['file_name']['type'][$i];

                // Moving files to zip.
                $zip->addFromString($_FILES['file_name']['name'][$i], file_get_contents($_FILES['file_name']['tmp_name'][$i]));

                // moving files to the target folder.

            }
            $zip->close();

            // Create HTML Link option to download zip
            $success = url('/') . '/uploads/support/' . basename($zip_name);

            $files = File::files('uploads/support');
            //dd($files[0]);

            // dd($files[0]->getContents());

            foreach ($files as $value) {
                if (str_contains($value->getFilenameWithoutExtension(), $request->support_email)) {
                    //echo($value->getFilenameWithoutExtension());
                    $api_string = "data:" . 'application/x-zip-compressed' . ';base64,' . base64_encode($value->getContents());

                    $zip_attachments[$value->getFilenameWithoutExtension() . '.zip'] = $api_string;

                    array_push($zip_attachments_wrapper, $zip_attachments);
                }
            }

        }

       

        $request->validate([
            'support_name' => 'required',
            'support_email' => 'required|email',
            'support_mobail' => 'required|size:11|regex:/(01)[0-9]{9}/',
            'support_subject' => 'required',
            'support_details' => 'required',
        ],
            [
                'support_name.required' => 'পুরো নাম লিখুন',
                'support_subject.required' => 'বিষয় দিতে হবে',
                'support_email.required' => 'আপনার ইমেইল লিখুন',
                'support_email.email' => 'সঠিক ইমেইল লিখুন',
                'support_mobail.required' => 'মোবাইল নং দিতে হবে',
                'support_mobail.size' => 'মোবাইল নং দিতে হবে 11 digit',
                'support_details.required' => 'বিস্তারিত দিতে হবে',

            ]);

       

        $config = array(
            'url' => 'http://localhost:8080/osTicket/upload/api/tickets.json',
            'key' => '760E2B4AB14BC82CF25499D0428A5128',
        );

        #pre-checks
        function_exists('curl_version') or die('CURL support required');

        #set timeout
        set_time_limit(1500);

        #Sample data for the ticket
        # See https://github.com/osTicket/osTicket-1.7/blob/develop/setup/doc/api/tickets.md for full list of variables and options that you can pass.
        $data = array("alert" => "true",
            "autorespond" => "true",
            "source" => "API",
            "name" => $request->support_name,
            "email" => $request->support_email,
            "phone" => $request->support_mobail,
            "subject" => $request->support_subject,
            "message" => $request->support_details,
            "attachments" => $zip_attachments_wrapper,
        );

        #Convert the above array into json to POST to the API with curl below.
        $data_string = json_encode($data);

       //  dd($data_string );

        #curl post
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $config['url']);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_USERAGENT, 'osTicket API Client v1.7');
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:', 'X-API-Key: ' . $config['key']));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        if (preg_match('/HTTP\/.* ([0-9]+) .*/', $result, $status) && $status[1] == 200) {
            exit(0);
        }
        else
        {
            return redirect()->back()->with('success','আপনার তথ্য Support টিমের কাছে পাঠানো হয়েছে সফলভাবে')->withInput();
        }
        //var_dump($result);
        exit(1);
    } 


}
