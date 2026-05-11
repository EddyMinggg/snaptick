<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>提交成功 - {{ $merchant->shop_name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center px-4">

    <div class="w-full max-w-sm text-center">

        {{-- 成功圖示 --}}
        <div class="flex items-center justify-center w-20 h-20 mx-auto rounded-full bg-green-100">
            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        {{-- 成功訊息 --}}
        <h1 class="mt-5 text-2xl font-bold text-gray-800">已成功提交！</h1>
        <p class="mt-3 text-sm text-gray-500 leading-relaxed">
            我們已收到您的入數截圖，<br>
            店主確認後將會盡快為您處理。
        </p>

        {{-- 商戶名稱 --}}
        <p class="mt-4 text-xs text-gray-400">— {{ $merchant->shop_name }}</p>

        {{-- 返回按鈕 --}}
        <a
            href="{{ route('payment.form', $merchant->slug) }}"
            class="mt-8 inline-block rounded-xl border border-gray-200 bg-white px-6 py-2.5 text-sm font-medium text-gray-600 shadow-sm hover:bg-gray-50"
        >
            返回上傳頁面
        </a>

        <p class="mt-8 text-xs text-gray-300">Powered by SnapTick 對數快</p>
    </div>

</body>
</html>
