<?php

namespace App\Imports;

use App\Models\Registrant;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RegistrantImport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements WithCustomValueBinder, WithHeadingRow, ToModel
{
//    use Importable;

//    public function mapping(): array
//    {
//        return [
//            'surname' => 'A1',
//            'firstname' => 'B1',
//        ];
//    }

    public function model(array $row)
    {
        return new Registrant([
            'surname' => $row[0],
            'firstname' => $row[1],
        ]);
    }

//    public function collection(Collection $collection)
//    {
//
////        return $collection;
//        foreach ($collection as $row)
//        {
//            return new Registrant([
//                'firstname' => $row[0],
//                'surname' => $row[1],
//            ]);
//        }
//    }
}
