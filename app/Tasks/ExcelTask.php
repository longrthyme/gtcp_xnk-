<?php

namespace App\Tasks;

use App\Constants\BaseConstants;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use InApps\IAModules\Helpers\LogHelper;

use App\Imports\CallImport;

class ExcelTask
{
    /**
     * @param $name
     * @return string
     */

    public function getData($url_excel)
    {
        try {
            $array = Excel::toArray(new CallImport, public_path($url_excel));
            Log::debug('process import excel');
            $new_array = array_chunk($array[0], 500);
            // dd($new_array[0]);

            \File::cleanDirectory(public_path('excel-render'));
            foreach($new_array as $index => $data)
            {
                $html = view('theme.news.file_import', ['data' => $data]);
                \File::put(public_path('excel-render/excel-render-'. $index+1 .'.html'), $html);
            }
            
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}
