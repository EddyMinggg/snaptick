<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // 顯示所有待處理 (pending) 的入數紀錄
    public function index()
    {
        $merchant = Auth::user()->merchant;

        // FIFO：舊的排前面，讓商戶先處理最早的訂單
        $records = $merchant->paymentRecords()
            ->where('status', 'pending')
            ->oldest()
            ->get();

        return view('dashboard', compact('merchant', 'records'));
    }

    // 核准一筆入數紀錄，並跳轉 WhatsApp 通知客人
    public function approve(Request $request, $id)
    {
        // 透過關聯查詢確保只能操作自己的紀錄，防止越權
        $record = Auth::user()->merchant->paymentRecords()->findOrFail($id);

        $record->status = 'approved';
        $record->save();

        // 組合 WhatsApp 通知文字
        $message = "你好！已確認收到訂單 {$record->customer_identifier} 的款項 HK\${$record->amount}，我們會盡快為你安排出貨，謝謝！";
        $encoded = urlencode($message);

        return redirect()->away("https://wa.me/?text={$encoded}");
    }

    // 退回一筆入數紀錄，並返回 Dashboard 帶 flash 訊息
    public function reject(Request $request, $id)
    {
        // 同樣透過關聯查詢防止越權
        $record = Auth::user()->merchant->paymentRecords()->findOrFail($id);

        $record->status = 'rejected';
        $record->save();

        return redirect()->route('dashboard')->with('flash_message', '已退回該筆入數。');
    }
}
