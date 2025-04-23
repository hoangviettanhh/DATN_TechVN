<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Collection;

class RevenueExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return new Collection($this->data['monthly_data']);
    }

    public function headings(): array
    {
        return [
            'Tháng',
            'Số đơn hàng',
            'Doanh số'
        ];
    }

    public function map($row): array
    {
        return [
            $row['month_name'],
            $row['total_orders'],
            $row['revenue']
        ];
    }
} 