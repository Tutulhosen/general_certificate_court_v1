<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCausePostRequest extends FormRequest
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
            
                'causeTitle' => 'required',
                'case_no' => 'required|string|unique:custom_causelist',
                'caseDate' => 'required|date',
                'lawSection' => 'required|string',
                'div_section' => 'required|string',
                'dis_section' => 'required|string',
                'upa_section' => 'required|string',
                'organization_type' => 'required|string',
                'org_name' => 'required|string',
                'organization_employee' => 'required|string',
                'designation' => 'required|string',
                // 'totalLoanAmount' => 'required|string',
                // 'totalLoanAmountText' => 'required|string',
                // 'totalcollectAmount' => 'required|string',
                // 'totalcollectAmountText' => 'required|string',
                'next_date' => 'required|date',
                'lastorderDate' => 'required|date',
                'defaulter_name' => 'required',
            
        ];
    }

    public function messages(): array
    {
        return [
            'causeTitle.required' => 'মামলার আদেশের শিরনাম দিতে হবে',
            'case_no.required' => 'মামলা নম্বর দিতে হবে',
            'case_no.string' => 'মামলা নম্বর অবশ্যই স্ট্রিং হতে হবে',
            'case_no.unique' => 'এই মামলা নাম্বার ইতপূর্বে ব্যবহার হয়েছে ',
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
            // 'totalLoanAmount.required' => 'মোট ঋণ পরিমাণ দিতে হবে',
            // 'totalLoanAmount.string' => 'মোট ঋণ পরিমাণ অবশ্যই স্ট্রিং হতে হবে',
            // 'totalLoanAmountText.required' => 'মোট ঋণ পরিমাণ কে কথায় দিতে হবে',
            // 'totalLoanAmountText.string' => 'মোট ঋণ পরিমাণ কে কথায় অবশ্যই স্ট্রিং হতে হবে',
            // 'totalcollectAmount.required' => 'মোট আদায় পরিমাণ দিতে হবে',
            // 'totalcollectAmount.string' => 'মোট আদায় পরিমাণ অবশ্যই স্ট্রিং হতে হবে',
            // 'totalcollectAmountText.required' => 'মোট আদায় পরিমাণ কে কথায় দিতে হবে',
            // 'totalcollectAmountText.string' => 'মোট আদায় পরিমাণ কে কথায় অবশ্যই স্ট্রিং হতে হবে',
            'next_date.required' => 'পরবর্তী তারিখ দিতে হবে',
            'lastorderDate.required' => 'শেষ আদেশের তারিখ দিতে হবে',
            'lastorderDate.date' => 'শেষ আদেশের তারিখ অবশ্যই তারিখ হতে হবে',
            'defaulter_name.required' => 'খাতকের নাম দিতে হবে ',
        ];
    }
}
