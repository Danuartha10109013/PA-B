<?php

namespace App\Http\Controllers;

use App\Models\AbsensiM;
use App\Models\LocationM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    public function index(){
        $absen = AbsensiM::where('user_id',Auth::user()->id)->get();
        $lokasi = LocationM::find(1);
        if(!$lokasi){
            return redirect()->back()->with('error','Admin Belum Menyesuaikan Titik Lokasi Absen');
        }
        return view('pages.pegawai.absensi.index',compact('absen','lokasi'));
    }
    public function data(){
        $absen = AbsensiM::where('user_id',Auth::user()->id)->get();
        return view('pages.pegawai.absensi.data',compact('absen'));
    }

    public function masuk(){
        $lokasi = LocationM::find(1);
        $acuan = Auth::user()->acuan;
        if(!$acuan){
            return redirect()->back()->with('error','Acuan absensi belum dilengkapi. Silahkan hubungi admin');
        }
        if(!$lokasi){
            return redirect()->back()->with('error','Admin Belum Menyesuaikan Titik Lokasi Absen');
        }
        return view('pages.pegawai.absensi.absen-masuk',compact('lokasi'));
    }


    // Method untuk handle absensi masuk
    public function absensiMasuk(Request $request)
    {
        // Validasi data yang dikirim
        $request->validate([
            'location_masuk' => 'required|string',
            'photo_masuk' => 'required|string',
        ]);

        // Ambil data lokasi (latitude, longitude)
        $location = $request->input('location_masuk');

        // Ambil data base64 dari foto
        $base64Photo = $request->input('photo_masuk');

        // Proses untuk menyimpan foto
       $photoPath = $this->savePhoto($base64Photo);

        $acuanPath = public_path('storage/'.Auth::user()->acuan);
        $absenPath = public_path($photoPath);
        $scriptPath = base_path('python/face_match.py'); // Pastikan file ini ada di folder: project-root/python/

        $command = "python " . escapeshellarg($scriptPath) . " " . escapeshellarg($acuanPath) . " " . escapeshellarg($absenPath) ;

        $output = [];
        exec($command, $output);
        $result = trim(end($output));
        $result = $output[0];
// Debug:
// dd( $result);

        if ($result === 'no_face') {
            return back()->with('error', 'Wajah tidak terdeteksi.');
        } elseif ($result === 'not_match') {
            return back()->with('error', 'Wajah tidak cocok dengan acuan.');
        } elseif ($result === 'match') {
            $absensi = new AbsensiM;
            $absensi->user_id = Auth::user()->id;
            $absensi->location = $request->input('location_masuk');
            $absensi->photo = $photoPath;
            $absensi->type = 'masuk';
            $absensi->save();
            return redirect()->route('pegawai.absensi')->with('success', 'Absensi berhasil. Wajah cocok.');
        } else {
            return redirect()->back()->with('error', 'Gagal memproses pengenalan wajah.');
        }
        // $command = "python python/face_match.py \"$acuanPath\" \"$absenPath\"";
        // $result = trim(shell_exec($command));

       


    }

    // Fungsi untuk menyimpan foto dalam format base64
    private function savePhoto($base64Photo)
    {
        // Decode base64 string menjadi file binary
        $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Photo));

        // Buat nama file unik
        $fileName = 'photo_' . time() . '.png';

        // Tentukan direktori penyimpanan, misal di storage/app/public/absensi
        $filePath = 'public/absensi/' . $fileName;

        // Simpan file ke storage Laravel
        Storage::put($filePath, $fileData);

        // Return path relatif yang dapat digunakan untuk ditampilkan atau disimpan di database
        return 'storage/absensi/' . $fileName;
    }

    public function pulang(){
         $lokasi = LocationM::find(1);
        if(!$lokasi){
            return redirect()->back()->with('error','Admin Belum Menyesuaikan Titik Lokasi Absen');
        }
        $acuan = Auth::user()->acuan;
        if(!$acuan){
            return redirect()->back()->with('error','Acuan absensi belum dilengkapi. Silahkan hubungi admin');
        }
        return view('pages.pegawai.absensi.absen-pulang',compact('lokasi'));
    }

    public function absensiPulang(Request $request){
         $request->validate([
            'location_pulang' => 'required|string',
            'photo_pulang' => 'required|string',
        ]);

        // Ambil data lokasi (latitude, longitude)
        $location = $request->input('location_pulang');

        // Ambil data base64 dari foto
        $base64Photo = $request->input('photo_pulang');

        // Proses untuk menyimpan foto
       $photoPath = $this->savePhoto($base64Photo);

        $acuanPath = public_path('storage/'.Auth::user()->acuan);
        $absenPath = public_path($photoPath);
        $scriptPath = base_path('python/face_match.py'); // Pastikan file ini ada di folder: project-root/python/

        $command = "python " . escapeshellarg($scriptPath) . " " . escapeshellarg($acuanPath) . " " . escapeshellarg($absenPath) ;

        $output = [];
        exec($command, $output);
        $result = trim(end($output));
        $result = $output[0];
// Debug:
// dd( $result);

        if ($result === 'no_face') {
            return back()->with('error', 'Wajah tidak terdeteksi.');
        } elseif ($result === 'not_match') {
            return back()->with('error', 'Wajah tidak cocok dengan acuan.');
        } elseif ($result === 'match') {
            $absensi = new AbsensiM;
            $absensi->user_id = Auth::user()->id;
            $absensi->location = $request->input('location_pulang');
            $absensi->photo = $photoPath;
            $absensi->type = 'pulang';
            $absensi->save();
            return redirect()->route('pegawai.absensi')->with('success', 'Absensi berhasil. Wajah cocok.');
        } else {
            return redirect()->back()->with('error', 'Gagal memproses pengenalan wajah.');
        }
    }

    // public function absensiPulang(Request $request){
    //     $request->validate([
    //         'location_pulang' => 'required|string',
    //     ]);

    //     $absensi = new AbsensiM;

    //     $absensi->location = $request->location_pulang;
    //     $absensi->user_id = Auth::user()->id;
    //     $absensi->type = "pulang";

    //     $absensi->save();

    //     return redirect()->route('pegawai.absensi')->with('success','Absen Pulang Sukses');

    // }

   public function storeacuan(Request $request)
{
    // Validasi file gambar wajib
    $request->validate([
        'acuan' => 'required|image|mimes:jpeg,png,jpg|max:2048', // max 2MB
    ]);

    // Ambil file
    $file = $request->file('acuan');

    // Buat nama file unik
    $filename = 'acuan_' . Auth::id() . '_' . time() . '.' . $file->getClientOriginalExtension();

    // Simpan ke folder public/storage/acuan
    $path = $file->storeAs('public/acuan', $filename);

    // Simpan path ke user (hanya relative path dari 'storage/')
    $user = Auth::user();
    $user->acuan = 'acuan/' . $filename;
    $user->save();

    return redirect()->back()->with('success', 'Foto acuan berhasil disimpan.');
}
}

