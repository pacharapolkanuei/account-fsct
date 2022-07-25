<?php
namespace App\Imports;
use App\Journalgeneraldetail;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class GeneralImports implements ToModel,WithHeadingRow
{
	/**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Journalgeneraldetail([
            'id_journalgeneral_head'     => $row['id_journalgeneral_head'],
            'accounttype'    => $row['accounttype'],
            'list'    => $row['list'],
            'name_suplier'     => $row['name_suplier'],
            'credit'    => $row['credit'],
            'debit'     => $row['debit']
        ]);
    }
}
