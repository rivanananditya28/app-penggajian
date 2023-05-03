<h1 align="center">APP-PENGGAJIAN</h1>
<h3 align="center">[SOLONET] - Aplikasi Penggajian Freelance PT. SOLO JALA BUANA</h3>

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Require
1. Composer
2. NPM
3. Mysql Database
## Instalasion
1. Clone this repository
2. configure .env file
3. Run `Composer install`
4. Run `php artisan key:generate`
5. Run `php artisan migrate`
6. Run `php artisan serve`


## Alur Bisnis
<p> Salah satu parameter besaran gaji freelance SOLONET berdasarkan pekerjaan mereka, tiap - tiap pekerjaan mempunyai bobot nilai tertentu, aplikasi ini digunakan untuk menghitung dan mempermudah pencacatan pekerjaan tersebut </p>

## Proses Perhitungan Manual
- [Perhitungan Manual](https://github.com/Dev-SOLONET/app-penggajian/raw/main/docs/Laporan-Bulan-September-Muhammad-Ferdiyanto.xlsx) 

## Desain Database 
<img align="center" src="/docs/desain-db.png" />

## Alur Aplikasi
<img align="center" src="/docs/alur-aplikasi.png" />

## Cronjob
```php
// Terdapat cronjob yang berjalan pada aplikasi ini yang bisa dibuka pada `app/Console/Kernel.php`
protected function schedule(Schedule $schedule)
    {
        //BACKUP DATABASE
        $schedule->command('cron:backup-db')->monthlyOn(1, '01:00'); 
        //GENERATE GAJI POKOK FREELANCE    
        $schedule->command('cron:gaji-pokok')->monthlyOn(1, '01:02');
        //IMPORT GAJI POKOK FREELANCE KE LABA RUGI
        $schedule->command('cron:import-gaji')->monthlyOn(1, '01:03');
    }
```




