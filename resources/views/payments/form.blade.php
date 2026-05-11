<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $merchant->shop_name }} - 入數截圖上傳</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center px-4 py-10">

    <div class="w-full max-w-md">

        {{-- 頂部商戶資訊 --}}
        <div class="mb-6 text-center">
            <p class="text-xs font-semibold uppercase tracking-widest text-indigo-500">入數確認</p>
            <h1 class="mt-1 text-2xl font-bold text-gray-800">{{ $merchant->shop_name }}</h1>
            <p class="mt-2 text-sm text-gray-500">請上傳您的 FPS / PayMe 入數截圖</p>
        </div>

        {{-- 驗證錯誤提示 --}}
        @if ($errors->any())
            <div class="mb-5 rounded-lg bg-red-50 border border-red-200 p-4 text-sm text-red-700">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- 入數表單，需加 enctype 才能上傳檔案 --}}
        <form
            method="POST"
            action="{{ route('payment.submit', $merchant->slug) }}"
            enctype="multipart/form-data"
            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5"
        >
            @csrf

            {{-- 顧客 IG 帳號 / 訂單號 --}}
            <div>
                <label for="customer_identifier" class="block text-sm font-medium text-gray-700">
                    你的 IG 帳號 / 訂單號碼
                </label>
                <input
                    id="customer_identifier"
                    type="text"
                    name="customer_identifier"
                    value="{{ old('customer_identifier') }}"
                    required
                    placeholder="例：@my_ig_handle 或 ORD-2024-001"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 @error('customer_identifier') border-red-400 bg-red-50 @enderror"
                />
            </div>

            {{-- 入數金額 --}}
            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700">
                    入數金額 (HKD)
                </label>
                <div class="mt-1 flex rounded-lg shadow-sm">
                    <span class="inline-flex items-center rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500">
                        HK$
                    </span>
                    <input
                        id="amount"
                        type="number"
                        name="amount"
                        value="{{ old('amount') }}"
                        required
                        min="0.01"
                        step="0.01"
                        placeholder="0.00"
                        class="block w-full rounded-none rounded-r-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 @error('amount') border-red-400 bg-red-50 @enderror"
                    />
                </div>
            </div>

            {{-- 截圖上傳 --}}
            <div>
                <label for="screenshot" class="block text-sm font-medium text-gray-700">
                    入數截圖
                </label>
                <div class="mt-1">
                    <input
                        id="screenshot"
                        type="file"
                        name="screenshot"
                        required
                        accept="image/*"
                        capture="environment"
                        class="block w-full text-sm text-gray-500
                               file:mr-3 file:py-2 file:px-4
                               file:rounded-lg file:border-0
                               file:text-sm file:font-medium
                               file:bg-indigo-50 file:text-indigo-700
                               hover:file:bg-indigo-100
                               @error('screenshot') border border-red-400 rounded-lg @enderror"
                    />
                </div>
                <p class="mt-1 text-xs text-gray-400">接受 JPG、PNG、GIF，最大 5MB。</p>
            </div>

            {{-- 提交按鈕 --}}
            <div class="pt-2">
                <button
                    type="submit"
                    class="w-full rounded-xl bg-indigo-600 px-4 py-3 text-base font-semibold text-white shadow-sm hover:bg-indigo-500 active:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >
                    提交入數截圖
                </button>
            </div>
        </form>

        <p class="mt-6 text-center text-xs text-gray-400">Powered by SnapTick 對數快</p>
    </div>

</body>
</html>
