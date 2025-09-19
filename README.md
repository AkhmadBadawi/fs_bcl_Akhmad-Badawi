Persyaratan: 
PHP 8.1+, Composer, MySQL, Node

Cara instal:
1. git clone <repo>

2. composer install

3. cp .env.example .env lalu atur DB

4. php artisan key:generate

5. php artisan migrate --seed

6. php artisan serve


Struktur Basis Data:
<img width="550" height="482" alt="image" src="https://github.com/user-attachments/assets/40847013-1169-402a-9f0c-25d5af4fea2e" />

1. Tabel fleets (Armada)

Menyimpan data armada yang digunakan untuk pengiriman.

Kolom	Tipe Data	Keterangan
id	BIGINT, PK	Primary key, auto increment.
plate_number	VARCHAR(50)	Nomor plat kendaraan, unik.
vehicle_type	VARCHAR(50)	Jenis kendaraan (misal: truck, van).
capacity	INT	Kapasitas muatan kendaraan (kg atau m³).
availability	ENUM	Status ketersediaan: available / unavailable.
created_at	TIMESTAMP	Waktu data dibuat.
updated_at	TIMESTAMP	Waktu data diupdate terakhir.

Relasi:

Satu armada bisa memiliki banyak shipments (pengiriman) dan bookings (pemesanan).

Satu armada bisa memiliki banyak fleet_checkins (lokasi check-in).

2. Tabel shipments (Pengiriman)

Menyimpan data pengiriman barang.

Kolom	Tipe Data	Keterangan
id	BIGINT, PK	Primary key, auto increment.
tracking_number	VARCHAR(50)	Nomor pengiriman unik.
shipped_at	DATE	Tanggal pengiriman.
origin	VARCHAR(100)	Lokasi asal barang.
destination	VARCHAR(100)	Lokasi tujuan barang.
status	ENUM	Status pengiriman: pending, in_transit, delivered.
details	TEXT	Detail barang dikirim (misal: nama barang, berat, jumlah).
fleet_id	BIGINT, FK	Mengacu ke fleets.id, nullable jika belum assign armada.
created_at	TIMESTAMP	Waktu data dibuat.
updated_at	TIMESTAMP	Waktu data diupdate terakhir.

Relasi:

Banyak pengiriman bisa di-handle oleh satu armada (fleet).

3. Tabel bookings (Pemesanan Armada)

Menyimpan pemesanan armada oleh pelanggan.

Kolom	Tipe Data	Keterangan
id	BIGINT, PK	Primary key, auto increment.
customer_name	VARCHAR(100)	Nama pelanggan yang memesan armada.
fleet_id	BIGINT, FK	Armada yang dipilih (nullable jika belum assign).
vehicle_type_requested	VARCHAR(50)	Jenis kendaraan yang diminta pelanggan.
booking_date	DATE	Tanggal pemesanan.
shipment_details	TEXT	Detail barang yang akan dikirim.
status	ENUM	Status pemesanan: pending, confirmed, cancelled.
created_at	TIMESTAMP	Waktu data dibuat.
updated_at	TIMESTAMP	Waktu data diupdate terakhir.

Relasi:

Setiap booking dapat assign ke satu armada (fleet).

4. Tabel fleet_checkins (Lokasi Check-In Armada)

Menyimpan data lokasi armada secara real-time.

Kolom	Tipe Data	Keterangan
id	BIGINT, PK	Primary key, auto increment.
fleet_id	BIGINT, FK	Armada yang melakukan check-in.
latitude	DECIMAL(10,7)	Koordinat lintang lokasi armada.
longitude	DECIMAL(10,7)	Koordinat bujur lokasi armada.
recorded_at	TIMESTAMP	Waktu check-in dicatat.
note	VARCHAR(255)	Catatan tambahan (opsional).
created_at	TIMESTAMP	Waktu data dibuat.
updated_at	TIMESTAMP	Waktu data diupdate terakhir.

Relasi:

Banyak check-in bisa dimiliki oleh satu armada (fleet).

5. Relasi Antar Tabel (Ringkas)

fleets 1 --- n shipments

fleets 1 --- n bookings

fleets 1 --- n fleet_checkins

bookings.fleet_id & shipments.fleet_id bersifat nullable agar fleksibel saat belum assign armada.
