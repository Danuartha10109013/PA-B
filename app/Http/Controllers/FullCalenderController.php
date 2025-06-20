<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FullCalenderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Cuti::where('jenis_cuti', '!=', 'lain-lain')
                ->whereDate('start', '>=', $request->start)
                ->whereDate('end', '<=', $request->end)
                ->get(['id', 'title', 'start', 'end', 'user_id', 'status'])
                ->map(function ($cuti) {
                    $user = \App\Models\User::find($cuti->user_id);
                    return [
                        'id' => $cuti->id,
                        'title' => $cuti->title,
                        'start' => $cuti->start,
                        // Add one day to the 'end' date
                        'end' => \Carbon\Carbon::parse($cuti->end)->addDay()->format('Y-m-d'),
                        'status' => $cuti->status,
                        'user_id' => $cuti->user_id,
                        'user_name' => $user->name ?? 'Unknown', // Getting the user name
                    ];
                });
    
            return response()->json($data);
        }
    
        return view('pages.pegawai.cuti.fullcalender');
    }
    
    public function ajax(Request $request): JsonResponse
    {
        switch ($request->type) {
            case 'add':
                return $this->handleAddEvent($request);

            case 'update':
                return $this->handleUpdateEvent($request);

            case 'delete':
                return $this->handleDeleteEvent($request);

            default:
                return response()->json(['error' => 'Invalid operation'], 400);
        }
    }

    private function handleAddEvent(Request $request): JsonResponse
{
    // Validasi input request
    $request->validate([
        'title' => 'required|string|max:255',
        'start' => 'required|date',
        'end' => 'required|date|after_or_equal:start',
        'alasan_cuti' => 'required|string',
    ]);

    $user = Auth::user();

    // Periksa apakah saldo cuti mencukupi (cukup 1 pengajuan)
    if ($user->saldo_cuti < 1) {
        return response()->json(['error' => 'Saldo Cuti kurang, Saldo: ' . $user->saldo_cuti], 400);
    }

    $newReason = $request->input('alasan_cuti');

    // Skor kriteria untuk setiap alasan cuti
    $criteriaScores = [
        'Pernikahan' => ['urgency' => 10, 'days' => 7, 'replacement' => 8, 'history' => 5],
        'Keperluan Keluarga' => ['urgency' => 8, 'days' => 6, 'replacement' => 7, 'history' => 6],
        'Urusan Pendidikan' => ['urgency' => 6, 'days' => 5, 'replacement' => 8, 'history' => 7],
        'Relaksasi' => ['urgency' => 4, 'days' => 5, 'replacement' => 7, 'history' => 8],
        'Liburan' => ['urgency' => 3, 'days' => 4, 'replacement' => 6, 'history' => 9],
    ];

    // Validasi alasan cuti
    if (!isset($criteriaScores[$newReason])) {
        return response()->json(['error' => 'Alasan cuti tidak valid'], 400);
    }

    // Periksa apakah sudah ada cuti pada tanggal yang diajukan
    $existingLeave = Cuti::where(function ($query) use ($request) {
        $query->whereBetween('start', [$request->start, $request->end])
              ->orWhereBetween('end', [$request->start, $request->end])
              ->orWhere(function ($query) use ($request) {
                  $query->where('start', '<=', $request->start)
                        ->where('end', '>=', $request->end);
              });
    })->exists();

    if ($existingLeave) {
        return response()->json(['error' => 'Sudah ada pegawai yang mengajukan cuti pada tanggal tersebut.'], 400);
    }

    // Bobot kriteria
    $weights = [
        'urgency' => 0.4,
        'days' => 0.3,
        'replacement' => 0.2,
        'history' => 0.1,
    ];

    // Hitung skor cuti baru berdasarkan kriteria
    $newLeaveScore = array_sum(array_map(
        fn($score, $weight) => $score * $weight,
        $criteriaScores[$newReason],
        $weights
    ));

    // Buat entri cuti baru
    $event = Cuti::create([
        'title' => $request->title,
        'start' => $request->start,
        'end' => $request->end,
        'user_id' => $user->id,
        'status' => 0,
        'alasan_cuti' => $newReason,
        'jenis_cuti' => 'tahunan',
        'score' => $newLeaveScore,
    ]);

    $startDate = Carbon::parse($request->start);
    $endDate = Carbon::parse($request->end);

    // Hitung total hari cuti (termasuk start dan end)
    $totalDays = $startDate->diffInDays($endDate) + 1;

    // Kurangi saldo cuti
    $user->saldo_cuti -= $totalDays;
    $user->save();

    return response()->json($event);
}

    
    

    private function handleUpdateEvent(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'required|exists:cuti,id',
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);

        $event = Cuti::find($request->id);

        if ($event->status == 1) {
            return response()->json(['error' => 'Sudah Disetujui, Tidak boleh berganti'], 400);
        }

        // Periksa apakah sudah ada cuti pada tanggal yang diajukan
        $existingLeave = Cuti::where(function ($query) use ($request) {
            $query->whereBetween('start', [$request->start, $request->end])
                ->orWhereBetween('end', [$request->start, $request->end])
                ->orWhere(function ($query) use ($request) {
                    $query->where('start', '<=', $request->start)
                            ->where('end', '>=', $request->end);
                });
        })->exists();

        if ($existingLeave) {
            return response()->json(['error' => 'Sudah ada pegawai yang mengajukan cuti pada tanggal tersebut.'], 400);
        }

        $event->update([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
        ]);

        return response()->json($event);
    }

    private function handleDeleteEvent(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'required|exists:cuti,id',
        ]);

        $event = Cuti::find($request->id);

        if ($event->status == 1) {
            return response()->json(['error' => 'Sudah Disetujui, Tidak Boleh Dihapus'], 400);
        }

        $startDate = Carbon::parse($event->start);
        $endDate = Carbon::parse($event->end);
        $totalDays = $startDate->diffInDays($endDate) + 1;

        // Kembalikan saldo cuti ke user
        $user = Auth::user();

        $user->saldo_cuti += $totalDays;
        $user->save();

        $event->delete();

        return response()->json(['success' => 'Event deleted successfully']);
    }
}
