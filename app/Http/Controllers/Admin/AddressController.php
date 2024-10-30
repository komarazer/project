<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThaiAmphure;
use App\Models\ThaiTambon;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    // API สำหรับดึงอำเภอตามจังหวัด
    public function getAmphures($province_id)
    {
        // ดึงข้อมูลอำเภอที่มี province_id ตรงกัน
        $amphures = ThaiAmphure::where('province_id', $province_id)->pluck('name_th', 'id');
        return response()->json($amphures);
    }

    // API สำหรับดึงตำบลตามอำเภอ
    public function getTambons($amphure_id)
    {
        // ดึงข้อมูลตำบลที่มี amphure_id ตรงกัน
        $tambons = ThaiTambon::where('amphure_id', $amphure_id)->pluck('name_th', 'id');
        return response()->json($tambons);
    }

    // API สำหรับดึงรหัสไปรษณีย์ตามตำบล
    public function getZipCode($tambon_id)
    {
        // ดึงรหัสไปรษณีย์จาก tambon
        $tambon = ThaiTambon::find($tambon_id);
        return response()->json(['zip_code' => $tambon->zip_code]);
    }
}