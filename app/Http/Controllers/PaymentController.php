<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\PaymentRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    // 顯示顧客入數表單
    public function showForm(string $slug)
    {
        // 根據 slug 找商戶，找不到直接 404
        $merchant = Merchant::where('slug', $slug)->firstOrFail();

        return view('payments.form', compact('merchant'));
    }

    // 接收並處理顧客提交的入數資料
    public function submitForm(Request $request, string $slug)
    {
        $merchant = Merchant::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'customer_identifier' => ['required', 'string', 'max:255'],
            'amount'              => ['required', 'numeric', 'gt:0'],
            // 只接受圖片，最大 5MB
            'screenshot'          => ['required', 'image', 'max:5120'],
        ]);

        // 將截圖上傳至 S3 / Cloudflare R2（磁碟由 FILESYSTEM_CLOUD 環境變數控制）
        $path = $request->file('screenshot')->store('screenshots', 's3');

        // 建立入數紀錄，status 預設為 pending
        PaymentRecord::create([
            'merchant_id'         => $merchant->id,
            'customer_identifier' => $validated['customer_identifier'],
            'amount'              => $validated['amount'],
            'screenshot_path'     => $path,
            'status'              => 'pending',
        ]);

        return redirect()->route('payment.success', $slug);
    }

    // 提交成功後的感謝頁面
    public function success(string $slug)
    {
        $merchant = Merchant::where('slug', $slug)->firstOrFail();

        return view('payments.success', compact('merchant'));
    }
}
