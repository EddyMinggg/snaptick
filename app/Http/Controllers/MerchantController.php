<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    // 顯示商戶設定表單
    public function create()
    {
        return view('merchants.setup');
    }

    // 接收表單、驗證並寫入 merchants 表
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shop_name'        => ['required', 'string', 'max:255'],
            // slug 只允許英數及橫線，且全域唯一
            'slug'             => ['required', 'string', 'regex:/^[a-z0-9\-]+$/', 'unique:merchants,slug'],
            // 香港電話：8 碼純數字
            'whatsapp_number'  => ['required', 'string', 'regex:/^[0-9]{8}$/'],
        ]);

        // 關聯到目前登入的用戶
        $request->user()->merchant()->create($validated);

        return redirect()->route('dashboard');
    }
}
