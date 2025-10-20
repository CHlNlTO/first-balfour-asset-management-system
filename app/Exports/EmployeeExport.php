<?php

namespace App\Exports;

use App\Models\CEMREmployee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Facades\Log;

class EmployeeExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        try {
            return CEMREmployee::with(['empService.rank', 'empService.position', 'empService.costCode', 'empService.project', 'empService.division', 'empService.status'])->get();
        } catch (\Exception $e) {
            Log::error('Error in EmployeeExport collection: ' . $e->getMessage());
            return collect([]);
        }
    }

    public function headings(): array
    {
        return [
            'ID NUMBER',
            'FIRST NAME',
            'MIDDLE NAME',
            'LAST NAME',
            'SUFFIX',
            'RANK',
            'CURRENT POSITION',
            'COST CODE',
            'PROJECT',
            'DIVISION',
            'CBE',
            'EMPLOYMENT STATUS'
        ];
    }

    public function map($employee): array
    {
        try {
            return [
                $employee->id_num ?? 'N/A',
                $employee->first_name ?? 'N/A',
                $employee->middle_name ?? '',
                $employee->last_name ?? 'N/A',
                $employee->suffix_name ?? '',
                $employee->empService?->rank?->name ?? 'N/A',
                $employee->empService?->position?->name ?? 'N/A',
                $employee->empService?->costCode?->name ?? 'N/A',
                $employee->empService?->project?->name ?? 'N/A',
                $employee->empService?->division?->name ?? 'N/A',
                $employee->cbe ? 'Y' : 'N',
                $employee->empService?->status?->name ?? 'N/A'
            ];
        } catch (\Exception $e) {
            Log::error('Error mapping employee ' . ($employee->id_num ?? 'unknown') . ': ' . $e->getMessage());
            return $this->getEmptyRow();
        }
    }



    private function getEmptyRow(): array
    {
        return array_fill(0, 12, 'N/A'); // 12 columns total
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2E8F0']
                ]
            ]
        ];
    }
}
