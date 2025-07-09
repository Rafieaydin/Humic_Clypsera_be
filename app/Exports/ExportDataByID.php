<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Pasien;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ExportDataByID implements FromQuery, WithHeadings, WithMapping, WithCustomStartCell, ShouldAutoSize, WithStyles, WithDrawings, WithColumnWidths
{
    use Exportable;
    private $id;
    public function __construct($id = null)
    {
        $this->id = $id;
    }
    private $drawings = [];
    private $drawingsCount = 1;
    public function query()
    {
        return Pasien::query()->with('operasi')
            ->whereHas('operasi', function ($query) {
                $query->where('id', $this->id)
                    ->orderBy('id', 'DESC');
            });
    }

    public function headings(): array
    {
        return [
            'id',
            'nama_pasien',
            'tanggal_lahir',
            'umur_pasien',
            'jenis_kelamin',
            'alamat_pasien',
            'no_telepon',
            'anak ke',
            'kelainan_kotigental',
            'riwayat_kehamilan',
            'riwayat_keluarga_pasien',
            'riwayat_kawin_berabat',
            'riwayat_terdahulu',
            'operasi_id',
            'tanggal_operasi',
            'tehnik_operasi',
            'lokasi_operasi',
            'foto_sebelum_operasi',
            'foto_setelah_operasi',
            'jenis_kelainan_cleft',
            'jenis_terapi',
            'diagnosis',
            'follow_up',
            'nama_operator',
            'nama_penyelenggara',
            'tanggal_pembuatan',
        ];
    }

    public function drawings()
    {
        return $this->drawings;
    }

    public function costomDrawings($name,$path, $coordinates)
    {
        $drawing = new Drawing();
        $drawing->setName($name);
        $drawing->setDescription($name);
        $drawing->setPath($path);
        $drawing->setHeight(height: 40);
        $drawing->setOffsetX(50);
        $drawing->setOffsetY(5);
        $drawing->setCoordinates($coordinates);
        $this->drawings[] = $drawing;
    }
    public function map($data): array // return array
    {
        $drawingCount= $this->drawingsCount + 3;
        $this->costomDrawings(
            'foto_sebelum_operasi',
            public_path(($data->operasi->foto_sebelum_operasi ?? null) != null ? $data->operasi->foto_sebelum_operasi : 'images\data_pasien\default.png'),
            'S' . ($drawingCount)
        );

        $this->costomDrawings(
            'foto_setelah_operasi',
            public_path(($data->operasi->foto_setelah_operasi ?? null) != null ? $data->operasi->foto_setelah_operasi : 'images\data_pasien\default.png'),
            'T' . ($drawingCount)
        );
        $this->drawingsCount++;
        return [
            '', // for id
            $data->nama_pasien,
            $data->tanggal_lahir,
            $data->umur_pasien,
            $data->jenis_kelamin,
            $data->alamat_pasien,
            str_split(strval($data->no_telepon),2)[0] . '-' . implode('-', array_slice(str_split(strval($data->no_telepon), 4), 1)),
            $data->pasien_anak_ke_berapa,
            $data->kelainan_kotigental,
            $data->riwayat_kehamilan,
            $data->riwayat_keluarga_pasien,
            $data->riwayat_kawin_berabat,
            $data->riwayat_terdahulu,
            $data->operasi->id ?? '',
            $data->operasi->tanggal_operasi ?? '',
            $data->operasi->tehnik_operasi ?? '',
            $data->operasi->lokasi_operasi ?? '',
            '',
            '',
            $data->operasi->jenisKelainan->nama_kelainan ?? '',
            $data->operasi->jenisTerapi->nama_terapi ?? '',
            $data->operasi->diagnosis->nama_diagnosis ?? '',
            $data->operasi->follow_up ?? '',
            $data->operasi->operator->name ?? '',
            $data->operasi->nama_penyelenggara ?? '',
            $data->created_at->format('Y-m-d H:i:s'),

        ];
    }

    public function styles($sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestCol = $sheet->getHighestColumn();

        $sheet->getStyle('B3:'.$highestCol.$highestRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B3:'.$highestCol.$highestRow)->getAlignment()->setVertical('center');
        $sheet->getStyle('B3:'.$highestCol.$highestRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('B3:'.$highestCol.$highestRow)->getFont()->setSize(12);


        // ini buat header
        $sheet->getStyle('B3:'.$highestCol.'3')->applyFromArray(array(
            "font" => array(
                'bold' => true,
                'color' => array('rgb' => 'FFFFFF')
            ),
            "fill" => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array(
                    'rgb' => '003030'
                )
            )
        ));

        // ini buat table border
        $sheet->getStyle('B3:'.$highestCol.$highestRow)->applyFromArray(array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],  // important
                    // 'width' => 10
                    'height' => 20
                )
            ),
        ));

        $sheet->getStyle('B4:'.'B'.$highestRow)->getAlignment()->setWrapText(true);
        $sheet->getRowDimension('3')->setRowHeight(30);

        for($i = 4; $i <= $highestRow; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(40);
        }
        // set increment column for numbering
        for ($i = 4; $i <= $highestRow; $i++) {
            $sheet->getCell('B' . $i)->setValue($i - 3);
        }


    }

    public function columnWidths(): array
    {
        return [
            'h' => 20,
            'T' => 30,
            'U' => 30,
        ];
    }

    public function startCell(): string
    {
        return 'B3';
    }
}
