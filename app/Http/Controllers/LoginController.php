<?php

namespace App\Http\Controllers;

use App\Mail\RegisterMail;
use App\Models\User;
use App\Models\UserVerification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Ramsey\Uuid\Uuid;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function verify(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = User::query()->where('email', $email)->first();

        #Error
        #1. Jika user dengan email input tidak ada
        if ($user == null) {
            return redirect()->route('login')->with('gagal', 'User tidak ditemukan');
        }
        #2. User ada, tapi password salah
        if (password_verify($password, $user->password) === false) {
            return redirect()->route('login')->with('gagal', 'Password Salah');;
        }
        #3. User tidak aktif (is_active = 0)
        if ($user->is_active == 0) {
            return redirect()->route('login')->with('gagal', 'silahkan aktivasi akun anda lewat email.');
        }

        #Kondisi user ada dan password benar
        #token
        $token = Uuid::uuid4()->toString();
        $user->update([
            'token' => $token
        ]);

        session([
            'token' => $token
        ]);

        return redirect()->route('books.index');
    }

    public function logout()
    {
        session()->forget('token');
        return redirect()->route('login');
    }

    public function prosesRegister(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;

        #1. cek apakah emailnya exist
        $user = User::query()->where('email', $email)->first();
        if ($user != null) {
            return redirect()->route('login')->with('gagal', 'Email sudah terdaftar');
        }

        #2. Simpan data user

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        #3. Buat kode otp, menggunakan faker, 4 angka random
        $otp = rand(1000, 9999);

        #4. Menggunakan Carbon kita membuat hari ini + 1 hari
        $expired = Carbon::now()->addDay(1);
        #5. Simpan data ke UserVerification
        $userVerification = UserVerification::create([
            'id_user' => $user->id,
            'otp' => $otp,
            'expired' => $expired
        ]);
        #6. Kirim email ke email nya
        Mail::to($email)->send(new RegisterMail($user, $userVerification));
        return redirect()->route('login');
    }

    public function registerVerify(Request $request)
    {
        #ambil parameter email dan otp
        $email = $request->email;
        $otp = $request->otp;
        #1. Cek apakah email nya ada
        $user = User::query()->where('email', $email)->first();

        if ($user == null) {
            return redirect()->route('login')->with('gagal', 'Email tidak ditemukan');
        }
        #2. Cek apakah otp nya sama
        $userVerification = UserVerification::query()->where('id_user', $user->id)->first();

        if ($userVerification == null) {
            return redirect()->route('login')->with('gagal', 'Otp tidak ditemukan');
        }
        if ($userVerification->otp != $otp) {
            return redirect()->route('login')->with('gagal', 'Otp tidak cocok');
        }
        if ($userVerification->expired < Carbon::now()) {
            return redirect()->route('login')->with('gagal', 'Otp sudah expired');
        }

        #3. Aktivasi user dengan mengganti is_active = 1
        $user->is_active = 1;
        $user->save();
        return redirect()->route('login');
    }
}