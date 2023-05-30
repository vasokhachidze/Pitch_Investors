<?php

namespace App\Imports;

use App\Models\admin\make\Make;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MakeImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        return new Make([
            'iMakeId'         => $row[0],
            'vUniqueCode'     => $row[1],
            'vTitle'          => $row[2], 
            'tDescription'    => $row[3],
            'vImage'          => $row[4],
            'eStatus'         => $row[5],
            'dtAddedDate'     => $row[6],
            'dtUpdateDate'    => $row[7],
            'eIsDeleted'      => $row[8],
        ]);
    }
}
