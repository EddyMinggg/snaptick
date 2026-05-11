# SnapTick 專案 AI 開發準則 (AI_RULES.md)

這是一份為 AI 開發助手準備的專案指南。在協助開發 SnapTick 時，請嚴格遵守以下架構與風格規範，避免產生幻覺或偏離現有設計。

## 1. 專案概述
- **專案名稱**：SnapTick (對數快)
- **目標客群**：香港 IG Shop / 小店老闆
- **核心功能**：讓顧客上傳 FPS/PayMe 截圖，讓商戶快速核對付款。
- **技術棧**：Laravel 11, PHP 8.x, SQLite (開發期), Tailwind CSS, Alpine.js, Blade Templates (Laravel Breeze)。

## 2. 核心資料表關聯
目前專案只有 3 張核心資料表，請勿自行發明其他關聯或表單：
1. `users`: Laravel 預設用戶表（即商戶登入帳號）。
2. `merchants`: 儲存商戶詳細資料。
   - `id`, `user_id`, `shop_name`, `slug` (唯一，用於專屬連結), `whatsapp_number`
   - 關聯：`User` hasOne `Merchant` / `Merchant` belongsTo `User`。
3. `payment_records`: 顧客上傳的入數紀錄。
   - `id`, `merchant_id`, `customer_identifier` (IG帳號/訂單號), `amount`, `screenshot_path`, `status` (預設 `pending`, 可為 `approved`, `rejected`)
   - 關聯：`Merchant` hasMany `PaymentRecord` / `PaymentRecord` belongsTo `Merchant`。

## 3. 開發風格與限制
- **極簡主義 (Minimalism)**：我們在開發 MVP (Minimum Viable Product)。請優先使用最簡單、最直覺的方法實現功能。不需要過度工程化（Over-engineering），例如不需要 Repository Pattern 或複雜的 Services 拆分，盡量在 Controller 內完成。
- **UI/UX 規範**：
  - 只能使用 Tailwind CSS 進行樣式設計，請勿寫自訂的 CSS 檔。
  - 設計必須是 Mobile-first（手機優先），確保按鈕足夠大，適合單手操作。
  - 使用 Laravel Breeze 的預設版型 (`x-app-layout` 或 `x-guest-layout`) 作為基礎。
- **檔案處理**：目前截圖先存放在本地 `storage/app/public` 中。請務必記得使用 `php artisan storage:link` 概念來處理圖片顯示。
- **語言與地區**：
  - 介面與註解請使用**繁體中文 (Traditional Chinese)**。
  - 商業情境基於**香港**（例如：貨幣單位為 HKD，電話號碼驗證為 8 碼）。

## 4. 中介層 (Middleware) 狀態
- `CheckHasMerchant`: 已配置於 `routes/web.php` 中的 `auth` 路由群組。已登入但尚未建立 `Merchant` 資料的用戶會被強制導向至 `/setup` 頁面。生成新路由時請注意此中介層的影響。

## 5. 撰寫程式碼的要求
當我要求你撰寫程式碼時：
1. 只提供修改的檔案名稱與相對應的程式碼區塊。
2. 保持現有檔案結構，除非我明確要求建立新檔案。
3. 提供清晰的中文註解說明商業邏輯。
4. 提供完程式碼後，簡述「下一步」的測試方法。