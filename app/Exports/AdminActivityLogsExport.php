<?php

namespace App\Exports;

use App\Models\AdminActivityLog;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class AdminActivityLogsExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    public function query()
    {
        return AdminActivityLog::query()
            ->orderByDesc('id')
            ->limit(5000);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Admin ID',
            'Model',
            'Model ID',
            'Route',
            'IP',
            'Changes',
            'Created At',
        ];
    }

    public function map($log): array
    {
        return [
            $log->id,
            $log->admin_id,
            model_display_name($log->model_type),
            $log->model_id,
            route_display_name($log->route),
            $log->ip,
//            $log->changes,
            $this->prettyJson($log->changes, $log->model_type),
            $log->getCreatedAt(),
        ];
    }

    protected function prettyJson($changes, $modelType): string
    {
        if (!$changes) {
            return '-';
        }

        $changes = json_decode($changes, true);

        if (!is_array($changes)) {
            return '-';
        }

        $lines = [];

        foreach ($changes as $field => $change) {
            $label = model_field_label($modelType, $field);

            $old = $change['old'] ?? '-';
            $new = $change['new'] ?? '-';

            $lines[] = "{$label}: {$old} => {$new}";
        }

        // هر تغییر در یک خط (Excel line break)
        return implode("\n", $lines);
    }

    public function styles(Worksheet $sheet)
    {
        // Wrap text for Changes column (G)
        $sheet->getStyle('G')->getAlignment()->setWrapText(true);

        // Optional: monospace font for JSON
        $sheet->getStyle('G')->getFont()->setName('Courier New');

        // Optional: column width
        $sheet->getColumnDimension('G')->setWidth(50);

        return [];
    }
}
