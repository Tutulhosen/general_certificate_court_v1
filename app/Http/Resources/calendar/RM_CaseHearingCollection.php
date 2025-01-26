<?php

namespace App\Http\Resources\calendar;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class RM_CaseHearingCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->total . ' টি রাজস্ব মামলা',
            'case_id' => $this->case_id,
            'start' => $this->hearing_date,
            'end' => $this->hearing_date,
            'description' => 'বিস্তারিত দেখুন',
            // 'className' => "fc-event-danger fc-event-solid-secondary",
            // 'className' => "fc-event-light fc-event-solid-success",
            'className' => "fc-event-light fc-event-solid-info",
            'url' => route('dateWaysRMCase') . '?date_start='. $this->hearing_date,
        ];
    }
}
