<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-gray-800">歡迎使用 SnapTick 對數快 👋</h1>
        <p class="mt-1 text-sm text-gray-500">請先設定你的店鋪資料，只需一分鐘。</p>
    </div>

    {{-- 驗證錯誤提示 --}}
    @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-700">
            <ul class="list-disc pl-4 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('merchant.setup.store') }}" class="space-y-5">
        @csrf

        {{-- 店名 --}}
        <div>
            <label for="shop_name" class="block text-sm font-medium text-gray-700">
                店鋪名稱
            </label>
            <input
                id="shop_name"
                type="text"
                name="shop_name"
                value="{{ old('shop_name') }}"
                required
                placeholder="例：小花手作"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('shop_name') border-red-500 @enderror"
            />
        </div>

        {{-- 專屬連結 Slug --}}
        <div>
            <label for="slug" class="block text-sm font-medium text-gray-700">
                專屬付款連結
            </label>
            <div class="mt-1 flex rounded-md shadow-sm">
                <span class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500">
                    snaptick.app/pay/
                </span>
                <input
                    id="slug"
                    type="text"
                    name="slug"
                    value="{{ old('slug') }}"
                    required
                    placeholder="myshop123"
                    class="block w-full rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('slug') border-red-500 @enderror"
                />
            </div>
            <p class="mt-1 text-xs text-gray-400">只能使用小寫英文、數字和橫線（-）。</p>
        </div>

        {{-- WhatsApp 號碼 --}}
        <div>
            <label for="whatsapp_number" class="block text-sm font-medium text-gray-700">
                WhatsApp 號碼
            </label>
            <div class="mt-1 flex rounded-md shadow-sm">
                <span class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500">
                    +852
                </span>
                <input
                    id="whatsapp_number"
                    type="text"
                    name="whatsapp_number"
                    value="{{ old('whatsapp_number') }}"
                    required
                    maxlength="8"
                    placeholder="98765432"
                    class="block w-full rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('whatsapp_number') border-red-500 @enderror"
                />
            </div>
            <p class="mt-1 text-xs text-gray-400">用於接收顧客入數通知，請輸入 8 位香港號碼。</p>
        </div>

        {{-- 提交按鈕 --}}
        <div class="pt-2">
            <button
                type="submit"
                class="w-full rounded-md bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >
                開始使用 →
            </button>
        </div>
    </form>
</x-guest-layout>
