<?php

namespace App\Exports;

use App\Models\Audits;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;




class AuditsExport implements FromQuery, WithMapping, WithColumnWidths, WithStyles, WithHeadings
{
    use Exportable;

    public function __construct(string $start_date, string $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function headings(): array
    {
        return [
            'Tanggal Audit',
            'Kategori',
            'Sub Kategori',
            'Deskripsi',
            'Rating',
        ];
    }


    public function map($audit): array
    {
        return [
            $audit->audit_date,
            $audit->category ? $audit->category->name : '',
            $audit->sub_category ? $audit->sub_category->name : '',
            $audit->description,
            $audit->rating,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 30,
            'C' => 40,
            'D' => 40,
            'E' => 10,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();

        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getStyle('1')->getAlignment()->setHorizontal('center');

        $sheet->getStyle('B')->getAlignment()->setWrapText(true); 
        $sheet->getStyle('C')->getAlignment()->setWrapText(true); 
        $sheet->getStyle('D')->getAlignment()->setWrapText(true);
        

        $sheet->getStyle('A2:A'.$lastRow)->getAlignment()->setHorizontal('center')->setVertical('top');
        $sheet->getStyle('B2:B'.$lastRow)->getAlignment()->setHorizontal('left')->setVertical('top');
        $sheet->getStyle('C2:C'.$lastRow)->getAlignment()->setHorizontal('left')->setVertical('top');
        $sheet->getStyle('D2:D'.$lastRow)->getAlignment()->setHorizontal('left')->setVertical('top');
        $sheet->getStyle('E2:E'.$lastRow)->getAlignment()->setHorizontal('center')->setVertical('top');
        
        
        // Note
        // Alignment::HORIZONTAL_GENERAL or 'general'
        // Alignment::HORIZONTAL_LEFT or 'left'
        // Alignment::HORIZONTAL_RIGHT or 'right'
        // Alignment::HORIZONTAL_CENTER or 'center'
        // Alignment::HORIZONTAL_CENTER_CONTINUOUS or 'centerContinuous'
        // Alignment::HORIZONTAL_JUSTIFY or 'justify'
        // Alignment::HORIZONTAL_FILL or 'fill'
        
        // Alignment::VERTICAL_BOTTOM or 'bottom'
        // Alignment::VERTICAL_TOP or 'top'
        // Alignment::VERTICAL_CENTER or 'center'
        // Alignment::VERTICAL_JUSTIFY or 'justify'

    }

    public function query()
    {
        if ($this->end_date) {
            $builder = Audits::query()
                        ->with([
                            'category',
                            'sub_category',
                        ])
                        ->where([
                            ['audit_date', '>=', $this->start_date],
                            ['audit_date', '<=', $this->end_date],
                        ]);
        }
        else {
            $builder = Audits::query()
                        ->with([
                            'category',
                            'sub_category',
                        ])
                        ->where('audit_date', '>=', $this->start_date);           
        }
        return $builder;
    }

}
