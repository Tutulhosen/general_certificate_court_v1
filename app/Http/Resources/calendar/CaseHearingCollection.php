<?php

namespace App\Http\Resources\calendar;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class CaseHearingCollection extends JsonResource
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
            'title' => $this->total . ' টি মামলা',
            'case_id' => $this->case_id,
            'start' => $this->hearing_date,
            'end' => $this->hearing_date,
            'description' => 'বিস্তারিত দেখুন',
            // 'className' => "fc-event-danger fc-event-solid-warning",
            'className' => "fc-event-light fc-event-solid-primary",
            'url' => route('dateWaysCase') . '?date_start='. $this->hearing_date,
        ];
    }
}
