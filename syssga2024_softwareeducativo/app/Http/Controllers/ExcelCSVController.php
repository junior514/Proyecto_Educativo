<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ComprobantesExport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelCSVController extends Controller
{
    public function exportExcelCSV($slug) 
    {
        return Excel::download(new ComprobantesExport, 'comprobantes_del_dia.'.$slug);
    }
}
