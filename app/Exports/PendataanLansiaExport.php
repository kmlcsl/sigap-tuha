<?php

namespace App\Exports;

use App\Models\PendataanLansia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PendataanLansiaExport implements FromCollection, WithEvents, WithTitle
{
    public function title(): string
    {
        return 'Pendataan Lansia';
    }

    public function collection()
    {
        return PendataanLansia::orderBy('kecamatan')->get();
    }

    /**
     * Bangun sheet secara penuh menggunakan AfterSheet event
     * agar bisa mengatur merge cell, header bertingkat, dan baris total.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $data  = PendataanLansia::orderBy('kecamatan')->get();

                $lastCol = 'AI';
                
                $lastRow  = 3 + $data->count();
                $totalRow = $lastRow + 1;

                // ── ROW 1: Judul ────────────────────────────────────────────
                $sheet->setCellValue('A1', 'PENDATAAN LANSIA');
                $sheet->mergeCells("A1:{$lastCol}1");
                $sheet->getStyle('A1')->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0B2C6B']],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(30);

                // ── ROW 2: Header Grup ──────────────────────────────────────
                // No & Kecamatan (merge baris 2-3)
                $sheet->setCellValue('A2', 'No');
                $sheet->mergeCells('A2:A3');
                $sheet->setCellValue('B2', 'Kecamatan');
                $sheet->mergeCells('B2:B3');

                // Grup header
                $tahun = date('Y');
                $groups = [
                    'C' => ['label' => 'Jumlah Penduduk ' . $tahun, 'end' => 'E'],
                    'F' => ['label' => 'Bayi Baru Lahir',  'end' => 'H'],
                    'I' => ['label' => 'Usia 0-11 Bulan',  'end' => 'K'],
                    'L' => ['label' => 'Usia 12-59 Bulan', 'end' => 'N'],
                    'O' => ['label' => 'Usia 60-72 Bulan', 'end' => 'Q'],
                    'R' => ['label' => 'Usia 7-9 Tahun',   'end' => 'T'],
                    'U' => ['label' => 'Usia 10-12 Tahun', 'end' => 'W'],
                    'X' => ['label' => 'Usia 13-14 Tahun', 'end' => 'Z'],
                    'AA'=> ['label' => 'Usia 15-59 Tahun', 'end' => 'AC'],
                    'AD'=> ['label' => 'Usia 60-69 Tahun', 'end' => 'AF'],
                    'AG'=> ['label' => 'Usia >70 Tahun',   'end' => 'AI'],
                ];

                // Warna bergantian untuk header grup
                $grupColors = ['1A56DB','1D4ED8','1E40AF','1D4ED8','1A56DB','2563EB','1D4ED8','1A56DB','2563EB','1D4ED8','1A56DB'];
                $gi = 0;
                foreach ($groups as $startCol => $info) {
                    $cell = "{$startCol}2";
                    $sheet->setCellValue($cell, $info['label']);
                    $sheet->mergeCells("{$startCol}2:{$info['end']}2");
                    $color = $grupColors[$gi % count($grupColors)];
                    $sheet->getStyle("{$startCol}2:{$info['end']}2")->applyFromArray([
                        'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                        'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $color]],
                    ]);
                    $gi++;
                }

                // ── ROW 3: Sub-header L / P / Total ─────────────────────────
                $subHeaders = ['A', 'B']; // no & kecamatan sudah di-merge
                // Kolom dimulai C
                $subCols = [
                    'C','D','E',
                    'F','G','H',
                    'I','J','K',
                    'L','M','N',
                    'O','P','Q',
                    'R','S','T',
                    'U','V','W',
                    'X','Y','Z',
                    'AA','AB','AC',
                    'AD','AE','AF',
                    'AG','AH','AI',
                ];
                $subLabels = array_fill(0, count($subCols) / 3, ['L','P','Total']);
                $flat = array_merge(...$subLabels);
                foreach ($subCols as $i => $col) {
                    $sheet->setCellValue("{$col}3", $flat[$i]);
                }

                // Style row 2 & 3 (A & B)
                $sheet->getStyle('A2:B3')->applyFromArray([
                    'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0B2C6B']],
                ]);
                $sheet->getStyle("C3:{$lastCol}3")->applyFromArray([
                    'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E3A8A']],
                ]);
                $sheet->getRowDimension(2)->setRowHeight(22);
                $sheet->getRowDimension(3)->setRowHeight(20);

                // ── ROW 4+: Data ─────────────────────────────────────────────
                $totals = array_fill(0, 35, 0); // 35 kolom data (C..AI)

                foreach ($data as $idx => $row) {
                    $r = $idx + 4;
                    $isEven = $idx % 2 === 0;
                    $bgColor = $isEven ? 'EFF6FF' : 'FFFFFF';

                    $values = [
                        $idx + 1,
                        $row->kecamatan,
                        $row->jumlah_penduduk_l,
                        $row->jumlah_penduduk_p,
                        $row->jumlah_penduduk_l + $row->jumlah_penduduk_p,
                        $row->bayi_baru_lahir_l,
                        $row->bayi_baru_lahir_p,
                        $row->bayi_baru_lahir_l + $row->bayi_baru_lahir_p,
                        $row->usia_0_11_bulan_l,
                        $row->usia_0_11_bulan_p,
                        $row->usia_0_11_bulan_l + $row->usia_0_11_bulan_p,
                        $row->usia_12_59_bulan_l,
                        $row->usia_12_59_bulan_p,
                        $row->usia_12_59_bulan_l + $row->usia_12_59_bulan_p,
                        $row->usia_60_72_bulan_l,
                        $row->usia_60_72_bulan_p,
                        $row->usia_60_72_bulan_l + $row->usia_60_72_bulan_p,
                        $row->usia_7_9_tahun_l,
                        $row->usia_7_9_tahun_p,
                        $row->usia_7_9_tahun_l + $row->usia_7_9_tahun_p,
                        $row->usia_10_12_tahun_l,
                        $row->usia_10_12_tahun_p,
                        $row->usia_10_12_tahun_l + $row->usia_10_12_tahun_p,
                        $row->usia_13_14_tahun_l,
                        $row->usia_13_14_tahun_p,
                        $row->usia_13_14_tahun_l + $row->usia_13_14_tahun_p,
                        $row->usia_15_59_tahun_l,
                        $row->usia_15_59_tahun_p,
                        $row->usia_15_59_tahun_l + $row->usia_15_59_tahun_p,
                        $row->usia_60_69_tahun_l,
                        $row->usia_60_69_tahun_p,
                        $row->usia_60_69_tahun_l + $row->usia_60_69_tahun_p,
                        $row->usia_70_plus_l,
                        $row->usia_70_plus_p,
                        $row->usia_70_plus_l + $row->usia_70_plus_p,
                    ];

                    $allCols = array_merge(['A', 'B'], $subCols);
                    foreach ($values as $ci => $val) {
                        $col = $allCols[$ci];
                        $sheet->setCellValue("{$col}{$r}", $val);
                        // Accumulate totals (skip No & Kecamatan)
                        if ($ci >= 2) {
                            $totals[$ci - 2] += (int) $val;
                        }
                    }

                    $sheet->getStyle("A{$r}:{$lastCol}{$r}")->applyFromArray([
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bgColor]],
                        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                    ]);
                    $sheet->getStyle("C{$r}:{$lastCol}{$r}")->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getRowDimension($r)->setRowHeight(18);
                }

                // ── BARIS TOTAL ──────────────────────────────────────────────
                // Nilai harus diset di sel A (kiri), karena saat merge nilai B diabaikan
                $sheet->setCellValue("A{$totalRow}", 'TOTAL');
                $sheet->mergeCells("A{$totalRow}:B{$totalRow}");

                foreach ($subCols as $ci => $col) {
                    $sheet->setCellValue("{$col}{$totalRow}", $totals[$ci]);
                }

                $sheet->getStyle("A{$totalRow}:{$lastCol}{$totalRow}")->applyFromArray([
                    'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0B2C6B']],
                ]);
                $sheet->getRowDimension($totalRow)->setRowHeight(22);

                // ── Border seluruh tabel ─────────────────────────────────────
                $sheet->getStyle("A2:{$lastCol}{$totalRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color'       => ['rgb' => 'BDD4FF'],
                        ],
                    ],
                ]);

                // ── Lebar kolom ──────────────────────────────────────────────
                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(22);
                foreach ($subCols as $col) {
                    $sheet->getColumnDimension($col)->setWidth(9);
                }

                // ── Freeze header ────────────────────────────────────────────
                $sheet->freezePane('C4');
            },
        ];
    }
}
