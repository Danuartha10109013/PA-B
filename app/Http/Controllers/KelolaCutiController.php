<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class KelolaCutiController extends Controller
{
    public function index(){
        $data = Cuti::where('status',0)->orderBy('created_at','desc')->get();
        $data1 = Cuti::where('status', '!=', '0')->orderBy('created_at','desc')->get();
        return view('pages.admin.kcuti.index',compact('data','data1'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        
        $cuti = Cuti::findOrFail($id);
        $start = Carbon::parse($cuti->start);
        $end = Carbon::parse($cuti->end);

        // Calculate the number of days
        $hari = -($end->diffInDays($start));
        // dd($hari);
        if($cuti->jenis_cuti == 'tahunan'){
            if ($request->status == "Disetujui") {
                // Calculate the number of days for the leave, including the start and end dates
                $saldo = Carbon::parse($cuti->start)->diffInDays(Carbon::parse($cuti->end)) + 1;

                $user = User::find($cuti->user_id);
            
                // Check if the user has enough leave balance
                if ($user->saldo_cuti < $saldo) {
                    return back()->with('error', 'Saldo Tidak mencukupi, sisa : ' . $user->saldo_cuti);
                }
            
                // Deduct the leave days from the user's balance
                $user->saldo_cuti = $user->saldo_cuti - $saldo;
                $user->save();
            }
            
        }
        $cuti->keterangan = $request->input('keterangan');
        if($request->status == "Disetujui"){
            $cuti->status = 1;
        }else{
            $cuti->status = 2;
        }
        $cuti->save();

        return redirect()->route('admin.kcuti')->with('success', 'Leave request updated successfully!');
    }

public function download($id)
{
    // Fetch the record from the Cuti model
    $cuti = Cuti::find($id);
    // dd($cuti);

    // Check if the record exists
    if (!$cuti) {
        return response()->json(['message' => 'Record tidak ditemukan.'], Response::HTTP_NOT_FOUND);
    }

    // Construct the full path to the file without 'assets'
    $path = public_path('storage/' . $cuti->bukti);

    // Debugging: Check the path (you can remove this in production)
    // dd($path);

    // Check if the file exists
    if (!file_exists($path)) {
        return response()->json(['message' => 'File tidak ditemukan.'], Response::HTTP_NOT_FOUND);
    }

    // Return the file as a download response
    return response()->download($path);
}

public function updatin(Request $request,$id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'jenis_cuti' => 'required|string|max:255',
            'alasan_cuti' => 'required|string',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'status' => 'required|in:2,1',
        ]);
    
        $cuti = Cuti::findOrFail($id);
        $ids = User::where('id', $cuti->user_id)->value('id');
        $uzer = User::find($ids);
        $saldo = Carbon::parse($request->start)->diffInDays(Carbon::parse($request->end)) + 1;

        if ($request->status == 1 && $cuti->jenis_cuti == 'tahunan' && $uzer->saldo_cuti < $saldo) {
            
            $cuti->update([
                'title' => $request->input('title'),
                'jenis_cuti' => $request->input('jenis_cuti'),
                'alasan_cuti' => $request->input('alasan_cuti'),
                'start' => $request->input('start'),
                'end' => $request->input('end'),
            ]);

            $user = Cuti::where('id', $id)->value('user_id');
            // dd($user);
            if ($user) {
                // Find the user and update their leave balance
                $userin = User::find($user);
                if($userin->saldo_cuti < $saldo){
                    $cutin = Cuti::find($id);
                    return redirect()->back()->with('error','Saldo cuti tidak mencukupi, Saldo : '.$userin->saldo_cuti);
                }else {
                    $userin->saldo_cuti = $userin->saldo_cuti - $saldo;
                    $userin->save();
                }
            }
        }elseif($request->status == 1 && $cuti->jenis_cuti == 'tahunan'){

            $cuti->update([
                'title' => $request->input('title'),
                'jenis_cuti' => $request->input('jenis_cuti'),
                'alasan_cuti' => $request->input('alasan_cuti'),
                'start' => $request->input('start'),
                'end' => $request->input('end'),
                'status' => $request->input('status'),
            ]);
            
            $user = Cuti::where('id', $id)->value('user_id');
            // dd($user);
            if ($user) {
                // Find the user and update their leave balance
                $userin = User::find($user);
                if($userin->saldo_cuti < $saldo){
                    $cutin = Cuti::find($id);
                    return redirect()->back()->with('error','Saldo cuti tidak mencukupi, Saldo : '.$userin->saldo_cuti);
                }else {
                    $userin->saldo_cuti = $userin->saldo_cuti - $saldo;
                    $userin->save();
                }
            }
        }
        else{
            $cuti->update([
                'title' => $request->input('title'),
                'jenis_cuti' => $request->input('jenis_cuti'),
                'alasan_cuti' => $request->input('alasan_cuti'),
                'start' => $request->input('start'),
                'end' => $request->input('end'),
                'status' => $request->input('status'),
            ]);

            $user = Cuti::where('id', $id)->value('user_id');
            // dd($user);
            if ($user) {
                // Find the user and update their leave balance
                $userin = User::find($user);
                
                if ($userin) {
                    $userin->saldo_cuti += $saldo;
                    $userin->save();
                }
            }
        }

    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Data cuti berhasil diperbarui.');
    }

    public function export(Request $request)
    {
        $tahun = $request->input('tahun', date('Y')); // Default ke tahun sekarang jika tidak ada input

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header
        $sheet->setCellValue('A1', 'Laporan Cuti Pegawai Tahun ' . $tahun);
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Set column headers
        $sheet->setCellValue('A3', 'No');
        $sheet->setCellValue('B3', 'Nama Pegawai');
        $sheet->setCellValue('C3', 'Jenis Cuti');
        $sheet->setCellValue('D3', 'Alasan Cuti');
        $sheet->setCellValue('E3', 'Tanggal Mulai');
        $sheet->setCellValue('F3', 'Tanggal Selesai');
        $sheet->setCellValue('G3', 'Status');
        $sheet->setCellValue('H3', 'Keterangan');

        // Style header
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E2EFDA']
            ]
        ];
        $sheet->getStyle('A3:H3')->applyFromArray($headerStyle);

        // Get data filtered by year
        $data = Cuti::with('user')
            ->whereYear('created_at', $tahun)
            ->orderBy('created_at', 'desc')
            ->get();

        // Fill data
        $row = 4;
        foreach ($data as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $item->user->name ?? '-');
            $sheet->setCellValue('C' . $row, $item->jenis_cuti);
            $sheet->setCellValue('D' . $row, $item->alasan_cuti);
            $sheet->setCellValue('E' . $row, Carbon::parse($item->start)->format('d/m/Y'));
            $sheet->setCellValue('F' . $row, Carbon::parse($item->end)->format('d/m/Y'));
            $sheet->setCellValue('G' . $row, $item->status == 1 ? 'Disetujui' : ($item->status == 2 ? 'Ditolak' : 'Menunggu'));
            $sheet->setCellValue('H' . $row, $item->keterangan ?? '-');
            $row++;
        }

        // Auto size columns
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Create Excel file
        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan_Cuti_Pegawai_' . $tahun . '.xlsx';
        
        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Save file to PHP output
        $writer->save('php://output');
        exit;
    }

}
