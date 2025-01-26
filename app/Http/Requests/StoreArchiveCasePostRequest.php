<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArchiveCasePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            
                'caseNo' => 'required|string',
                'caseDate' => 'required|date',
                'lawSection' => 'required|string',
                'div_section' => 'required|string',
                'dis_section' => 'required|string',
                'upa_section' => 'required|string',
                'organization_type' => 'required|string',
                'org_name' => 'required|string',
                'organization_employee' => 'required|string',
                'designation' => 'required|string',
                'totalLoanAmount' => 'required|string',
                'totalLoanAmountText' => 'required|string',
                'totalcollectAmount' => 'required|string',
                'totalcollectAmountText' => 'required|string',
                'lastorderDate' => 'required|date',
                'file_type'=> 'required',
                'attached_file' => 'required|file|mimes:pdf,jpg,png', // Assuming it's an uploaded file
            
        ];
    }

    public function messages(): array
    {
        return [
            'caseNo.required' => 'মামলা নম্বর দিতে হবে',
            'caseNo.string' => 'মামলা নম্বর অবশ্যই স্ট্রিং হতে হবে',
            'caseDate.required' => 'মামলা তারিখ দিতে হবে',
            'caseDate.date' => 'মামলা তারিখ অবশ্যই তারিখ হতে হবে',
            'lawSection.required' => 'আইন ধারা দিতে হবে',
            'lawSection.string' => 'আইন ধারা অবশ্যই স্ট্রিং হতে হবে',
            'div_section.required' => 'বিভাগ দিতে হবে',
            'div_section.string' => 'বিভাগ অবশ্যই স্ট্রিং হতে হবে',
            'dis_section.required' => 'জেলা দিতে হবে',
            'dis_section.string' => 'জেলা অবশ্যই স্ট্রিং হতে হবে',
            'upa_section.required' => 'উপজেলা দিতে হবে',
            'upa_section.string' => 'উপজেলা অবশ্যই স্ট্রিং হতে হবে',
            'organization_type.required' => 'প্রতিষ্ঠানের ধরন দিতে হবে',
            'organization_type.string' => 'প্রতিষ্ঠানের ধরন অবশ্যই স্ট্রিং হতে হবে',
            'org_name.required' => 'প্রতিষ্ঠানের নাম দিতে হবে',
            'org_name.string' => 'প্রতিষ্ঠানের নাম অবশ্যই স্ট্রিং হতে হবে',
            'organization_employee.required' => 'প্রতিষ্ঠানের কর্মচারী দিতে হবে',
            'organization_employee.string' => 'প্রতিষ্ঠানের কর্মচারী অবশ্যই স্ট্রিং হতে হবে',
            'designation.required' => 'পদবী দিতে হবে',
            'designation.string' => 'পদবী অবশ্যই স্ট্রিং হতে হবে',
            'totalLoanAmount.required' => 'মোট ঋণ পরিমাণ দিতে হবে',
            'totalLoanAmount.string' => 'মোট ঋণ পরিমাণ অবশ্যই স্ট্রিং হতে হবে',
            'totalLoanAmountText.required' => 'মোট ঋণ পরিমাণ কে কথায় দিতে হবে',
            'totalLoanAmountText.string' => 'মোট ঋণ পরিমাণ কে কথায় অবশ্যই স্ট্রিং হতে হবে',
            'totalcollectAmount.required' => 'মোট আদায় পরিমাণ দিতে হবে',
            'totalcollectAmount.string' => 'মোট আদায় পরিমাণ অবশ্যই স্ট্রিং হতে হবে',
            'totalcollectAmountText.required' => 'মোট আদায় পরিমাণ কে কথায় দিতে হবে',
            'totalcollectAmountText.string' => 'মোট আদায় পরিমাণ কে কথায় অবশ্যই স্ট্রিং হতে হবে',
            'lastorderDate.required' => 'শেষ আদেশের তারিখ দিতে হবে',
            'lastorderDate.date' => 'শেষ আদেশের তারিখ অবশ্যই তারিখ হতে হবে',
            // 'other_attachment_count.required' => 'অন্যান্য সংযুক্তি সংখ্যা অবশ্যই প্রয়োজন',
          /*   'other_attachment_count.array' => 'অন্যান্য সংযুক্তি সংখ্যা অবশ্যই প্রয়োজন',
            'other_attachment_count.min' => 'অন্যান্য সংযুক্তি সংখ্যা অবশ্যই কমপক্ষে 1 হতে হবে', */
            'attached_file.file' => 'সংযুক্তি অবশ্যই একটি ফাইল হতে হবে',
            'attached_file.required'=>  'অবশ্যই একটি ফাইল সংযুক্তি হতে হবে',
            'attached_file.mimes' => 'সংযুক্তি একটি সঠিক ফাইল টাইপ হতে হবে (pdf, jpg, png)',
        ];
    }
}
