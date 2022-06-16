<?php

namespace App\Exports;

use App\BestExpress\Tracking;
use Maatwebsite\Excel\Concerns\FromCollection;

class TrackingExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Tracking::all();
    }
}
