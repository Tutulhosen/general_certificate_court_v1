<?php

namespace App\Http\Resources\calendar;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class GccAppealHearingCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // dd($request);
        return [
            'id' => $this->id,
            'title' => $this->total . ' টি মামলা',
            'case_id' => $this->id,
            'start' => $this->next_date,
            'end' => $this->next_date,
            'description' => 'বিস্তারিত দেখুন',
            // 'className' => "fc-event-danger fc-event-solid-warning",
            'className' => "fc-event-light fc-event-solid-primary",
            'url' => route('appeal_hearing_list') . '?date_start='. $this->next_date,
        ];
    }
}
