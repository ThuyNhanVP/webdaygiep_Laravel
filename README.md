# 👟 Website Bán Giày Dép  

## 📌 Giới thiệu  
Dự án này là một website bán giày dép trực tuyến, được xây dựng bằng **Laravel 11** để xử lý chức năng đăng ký, đăng nhập, đăng xuất.  
Website cung cấp tính năng quản lý sản phẩm, giỏ hàng và đặt hàng.  

---

## ⚙️ Công nghệ sử dụng  
- **Backend:** Laravel 11, PHP 8.2  
- **Frontend:** Blade Template, TailwindCSS, Alpine.js  
- **Database:** MySQL   
- **Quản lý code:** GitHub  

---

## 🚀 Tính năng chính  
- 🔑 Đăng ký, đăng nhập, đăng xuất người dùng 
- 🛒 Quản lý giỏ hàng  
- 📦 Quản lý sản phẩm (CRUD giày dép)  
- 📝 Đặt hàng và quản lý đơn hàng  

---

## 🛠️ Cách cài đặt và chạy dự án  

1. Clone project về máy:  
   ```bash
   git clone https://github.com/ThuyNhanVP/webdaygiep_Laravel.git
   cd webdaygiep_Laravel
2. Cài đặt package:
   ```bash
    composer install
    npm install
    npm run dev
3. Tạo file .env:
   ```bash
   cp .env.example .env
4. Generate key:
   ```bash
   php artisan key:generate
5. Tạo database trong MySQL, sau đó cấu hình trong file .env:
   ```makefile
    DB_DATABASE=shoe_shop  
    DB_USERNAME=root  
    DB_PASSWORD=
6. Chạy migration:
   ```bash
   php artisan migrate
7. Khởi động server:
   ```bash
   php artisan serve
# 👨‍💻 Thành viên
- Trần Nguyễn Thuỵ Nhân
