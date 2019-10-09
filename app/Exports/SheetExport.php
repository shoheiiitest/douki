<?php

namespace App\Exports;

use App\Sheet;
use App\Cases;
use App\CaseContent;
use App\Header;
use App\Exports\SheetDataExport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
//use Maatwebsite\Excel\Concerns\FromArray;
//use Maatwebsite\Excel\Concerns\WithHeadings;
//use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SheetExport implements FromCollection,WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($project_id,$sheet_id)
    {
        $this->project_id = $project_id;
        $this->sheet_id = $sheet_id;
    }

    /**
     * @return Collection
     */
    public function collection()
    {

    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [
            new SheetDataExport($this->project_id,$this->sheet_id),
            new SheetDataExport($this->project_id,$this->sheet_id),
        ];

        return $sheets;
    }
}
