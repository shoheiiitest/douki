<?php

namespace App\Exports;

use App\Sheet;
use App\Cases;
use App\CaseContent;
use App\Header;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class SheetDataExport implements FromArray,WithHeadings,WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($project_id,$sheet_id)
    {
        $this->project_id = $project_id;
        $this->sheet_id = $sheet_id;
        $this->col_name = \App\Header::where('project_id',$project_id)
            ->where('disp_flg',1)
            ->orderBy('order_num','asc')
            ->pluck('col_name')
            ->toArray();
        $this->header = new Header();
        $this->sheet = new Sheet();
        $this->case = new Cases();
        $this->case_contents = new CaseContent();
    }


    /**
     * @return array
     */
    public function headings(): array
    {
        return $this->col_name;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        $caseIds = \App\Cases::where('sheet_id',$this->sheet_id)->orderBy('case_no','asc')->pluck('id')->toArray();
        $ret = [];
        $headerIds = \App\Header::where('project_id',$this->project_id)->where('disp_flg',1)->orderBy('order_num','asc')->pluck('id')->toArray();
        foreach ($caseIds as $index => $case_id){
            foreach ($headerIds as $i => $header_id){
                $case_content = $this->case_contents->where('case_id',$case_id)->where('header_id',$header_id)->pluck('content')->toArray();
                $ret[$index][$i] = $case_content[0];
            }
        }
        return [$ret];
    }

    public function title(): string{
        $sheet_name = $this->sheet->find($this->sheet_id)->sheet_name;
        return $sheet_name;
    }
}
