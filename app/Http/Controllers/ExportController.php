<?php

namespace App\Http\Controllers;

use App\Exports\AssignmentReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function exportAssetReport()
    {
        $filename = 'asset_assignment_report_' . date('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new AssignmentReportExport(), $filename);
    }
}
