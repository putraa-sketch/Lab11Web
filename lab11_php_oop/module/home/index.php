<?php
/**
 * File: module/home/index.php
 * Deskripsi: Halaman home/dashboard
 */
?>

<div style="text-align: center; padding: 40px 20px;">
    <h2 style="color: #667eea; margin-bottom: 20px;">
        ✨ Selamat Datang di Framework Modular PHP OOP
    </h2>
    
    <p style="font-size: 18px; color: #6c757d; margin-bottom: 40px;">
        Framework sederhana dengan konsep Modularisasi dan Routing
    </p>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 40px;">
        
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; border-radius: 10px; color: white; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            <h3 style="margin-bottom: 15px;">📦 Modularisasi</h3>
            <p style="opacity: 0.9;">Struktur folder terorganisir dengan baik untuk memudahkan pengembangan</p>
        </div>
        
        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); padding: 30px; border-radius: 10px; color: white; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            <h3 style="margin-bottom: 15px;">🛣️ Routing</h3>
            <p style="opacity: 0.9;">Sistem routing yang clean dan mudah dipahami dengan .htaccess</p>
        </div>
        
        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); padding: 30px; border-radius: 10px; color: white; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            <h3 style="margin-bottom: 15px;">🎯 OOP</h3>
            <p style="opacity: 0.9;">Menggunakan konsep Object-Oriented Programming untuk code yang reusable</p>
        </div>
        
    </div>
    
    <div style="margin-top: 50px; padding: 30px; background: #f8f9fa; border-radius: 10px; border-left: 5px solid #667eea;">
        <h3 style="color: #333; margin-bottom: 15px;">🚀 Fitur Aplikasi</h3>
        <ul style="list-style: none; padding: 0; text-align: left; max-width: 600px; margin: 0 auto;">
            <li style="padding: 10px 0; border-bottom: 1px solid #e9ecef;">✅ CRUD Data User dengan OOP</li>
            <li style="padding: 10px 0; border-bottom: 1px solid #e9ecef;">✅ Class Database untuk operasi database</li>
            <li style="padding: 10px 0; border-bottom: 1px solid #e9ecef;">✅ Class Form untuk generate form dinamis</li>
            <li style="padding: 10px 0; border-bottom: 1px solid #e9ecef;">✅ Template system untuk layout</li>
            <li style="padding: 10px 0;">✅ Routing dengan URL rewriting</li>
        </ul>
    </div>
    
    <div style="margin-top: 30px;">
        <a href="/lab11_php_oop/index.php/user/list" style="display: inline-block; padding: 15px 40px; background: #667eea; color: white; text-decoration: none; border-radius: 50px; font-weight: 600; transition: all 0.3s; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);">
            Lihat Data User 👉
        </a>
    </div>
</div>