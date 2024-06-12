# Catatan Perintah untuk Menjalankan Proyek Laravel

Berikut adalah perintah-perintah yang digunakan untuk menjalankan proyek Laravel:

## Menjalankan Server Laravel

Untuk menjalankan server Laravel, gunakan perintah berikut:

```sh
php artisan serve
```
Perintah ini akan menjalankan server pengembangan Laravel di alamat http://localhost:8000.

## Menjalankan Build Dev dengan NPM
Untuk menjalankan build pengembangan dengan NPM, gunakan perintah berikut:

```sh
npm run dev
```
Perintah ini akan menjalankan Webpack untuk memantau perubahan pada berkas JavaScript dan CSS, serta membangun ulang bundle ketika terjadi perubahan.

## Menjalankan Websocket Server
Untuk menjalankan server WebSocket, gunakan perintah berikut:

```sh
php artisan websocket:serve
```
Perintah ini akan menjalankan server WebSocket yang digunakan untuk komunikasi waktu nyata dalam aplikasi Anda.