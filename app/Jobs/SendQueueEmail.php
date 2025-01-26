<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendQueueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;
    public $timeout = 7200;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        //
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data['title'] = $this->details['email_subject'];
        $data['body'] = $this->details['email_body'];

        $data['court_name'] = $this->details['court_name'];
        $data['month_name'] = $this->details['month_name'];
        $data['day'] = $this->details['day'];
        $data['year'] = $this->details['year'];
        $data['user_name'] = $this->details['user_name'];
        $data['user_designation'] = $this->details['user_designation'];
        $data['shortorderTemplateUrl'] = $this->details['shortorderTemplateUrl'];
        $data['shortorderTemplateName'] = $this->details['shortorderTemplateName'];

        foreach ($this->details['receivers_emails_array'] as $key => $value) {

            $data["email_address_receiver"] = $value;
            $data["name_of_receiver"] = $this->details['receivers_names_array'][$key];

            Mail::send('Email_templates.email_template', $data, function ($message) use ($data) {
                $message->to($data["email_address_receiver"], $data["name_of_receiver"])
                    ->subject($data["title"]);
                $message->from('a2iecourt@gmail.com', 'Virtual Court');
            });
        }
    }
}
