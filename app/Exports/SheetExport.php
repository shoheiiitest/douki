<?php

namespace App\Exports;

use App\Sheet;
use App\Cases;
use App\CaseContent;
use App\Header;
//use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
//use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SheetExport implements FromArray,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($project_id,$sheet_id)
    {
        $this->project_id = $project_id;
        $this->sheet_id = $sheet_id;
        $this->header = \App\Header::where('project_id',$project_id)->orderBy('order_num','asc')->get('col_name')->toArray();
    }

//    public function collection()
//    {
//        return new Sheet([
//            [1,2,5]
//        ]);
////        return \App\Sheet::select("sheet_name")->get()->toArray();
//    }


    /**
     * @return array
     */
    public function headings(): array
    {
        $ret = [];
        foreach($this->header as $i => $v){
            $ret[] = $v['col_name'];
        }
        return $ret;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        return [
            [1,2,3],
            [4,5,6],
        ];
    }
}
