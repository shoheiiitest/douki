<?php

namespace App\Imports;

use App\Sheet;
use App\Imports\SheetImport;
//use Maatwebsite\Excel\Concerns\ToModel;
//use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultiSheetImport implements WithMultipleSheets
{

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
//    public function model(array $row)
//    {
//        dd($row);
//        return new Sheet([
//            $row
//        ]);
//    }


    public function sheets(): array
    {
        return [
            new SheetImport()
        ];
    }

}
