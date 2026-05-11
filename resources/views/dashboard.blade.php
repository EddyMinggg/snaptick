<x-app-layout>
@use('Illuminate\Support\Facades\Storage')
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $merchant->shop_name }} — 待審核入數
            </h2>
            {{-- 專屬收款連結 --}}
            <a
                href="{{ route('payment.form', $merchant->slug) }}"
                target="_blank"
                class="text-xs text-indigo-500 underline underline-offset-2"
            >
                我的收款連結 ↗
            </a>
        </div>
    </x-slot>

    <div class="py-6 px-4 max-w-2xl mx-auto space-y-4">

        {{-- 退回成功的 Flash 訊息 --}}
        @if (session('flash_message'))
            <div class="rounded-lg bg-yellow-50 border border-yellow-200 px-4 py-3 text-sm text-yellow-800">
                {{ session('flash_message') }}
            </div>
        @endif

        {{-- 沒有待審核資料時的友善提示 --}}
        @if ($records->isEmpty())
            <div class="flex flex-col items-center justify-center rounded-2xl bg-white border border-gray-100 shadow-sm py-16 text-center">
                <span class="text-5xl">🎉</span>
                <p class="mt-4 font-semibold text-gray-700">太棒了！目前沒有待處理的入數截圖</p>
                <p class="mt-1 text-sm text-gray-400">所有入數都已處理完畢。</p>
            </div>

        @else
            {{-- 付款紀錄卡片列表 --}}
            @foreach ($records as $record)
                <div class="rounded-2xl bg-white border border-gray-100 shadow-sm overflow-hidden">

                    {{-- 卡片頂部：客人資訊 + 金額 --}}
                    <div class="flex items-center justify-between px-4 pt-4 pb-3">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">顧客 IG / 訂單號</p>
                            <p class="mt-0.5 font-semibold text-gray-800">{{ $record->customer_identifier }}</p>
                        </div>
                        {{-- 金額大字顯示 --}}
                        <div class="text-right">
                            <p class="text-xs text-gray-400">金額</p>
                            <p class="text-2xl font-bold text-indigo-600">HK${{ number_format($record->amount, 2) }}</p>
                        </div>
                    </div>

                    {{-- 截圖預覽：從 S3/R2 取得公開 URL --}}
                    <div class="px-4 pb-3">
                        <img
                            src="{{ Storage::disk('s3')->url($record->screenshot_path) }}"
                            alt="入數截圖"
                            class="w-full h-64 object-contain rounded-xl bg-gray-50 border border-gray-100"
                        />
                    </div>

                    {{-- 提交時間 --}}
                    <div class="px-4 pb-2">
                        <p class="text-xs text-gray-400">
                            提交於 {{ $record->created_at->setTimezone('Asia/Hong_Kong')->format('Y-m-d H:i') }}
                        </p>
                    </div>

                    {{-- 操作按鈕區 --}}
                    <div class="flex gap-2 px-4 pb-4">

                        {{-- 核准按鈕（綠色，佔大比例）--}}
                        <form method="POST" action="{{ route('dashboard.approve', $record->id) }}" class="flex-1">
                            @csrf
                            <button
                                type="submit"
                                class="w-full rounded-xl bg-green-500 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-green-400 active:bg-green-600"
                                onclick="return confirm('確認核准這筆入數？')"
                            >
                                核准 ✅
                            </button>
                        </form>

                        {{-- 退回按鈕（灰紅色，佔小比例）--}}
                        <form method="POST" action="{{ route('dashboard.reject', $record->id) }}" class="w-1/3">
                            @csrf
                            <button
                                type="submit"
                                class="w-full rounded-xl bg-gray-100 px-4 py-3 text-sm font-semibold text-red-500 shadow-sm hover:bg-red-50 active:bg-red-100"
                                onclick="return confirm('確認退回這筆入數？')"
                            >
                                退回 ❌
                            </button>
                        </form>

                    </div>
                </div>
            @endforeach
        @endif

    </div>
</x-app-layout>
