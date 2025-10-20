<?php

namespace App\Http\Controllers;

use App\Exports\AssignmentReportExport;
use App\Exports\AssetReportExport;
use App\Exports\EmployeeExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function exportAssignmentReport()
    {
        $filename = 'asset_assignment_report_' . date('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new AssignmentReportExport(), $filename);
    }

    public function exportAssetReport()
    {
        $filename = 'asset_report_' . date('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new AssetReportExport(), $filename);
    }

    public function exportEmployeeReport()
    {
        $filename = 'employees_export_' . date('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new EmployeeExport(), $filename);
    }
}
