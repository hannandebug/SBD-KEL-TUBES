# 📋 Panduan Migrasi SQLite → MySQL & Setup Features Foto

## ✅ Yang Sudah Dilakukan (Completed)

### 1. **Konfigurasi Database (.env)**
- ✅ Diubah dari `DB_CONNECTION=sqlite` menjadi `DB_CONNECTION=mysql`
- ✅ MySQL credentials sudah dikonfigurasi:
  - Host: 127.0.0.1
  - Port: 3306
  - Database: sbd_kel_tubes
  - Username: root
  - Password: (kosong)

### 2. **Model Updates**
- ✅ Event model: Ditambahkan `getPhotoUrlAttribute()` accessor
- ✅ Group model: Ditambahkan `getPhotoUrlAttribute()` accessor
- ✅ Fallback photo URL menggunakan placeholder jika tidak ada foto

### 3. **View Updates**
- ✅ index.blade.php: Featured groups & events dengan foto
- ✅ groups.blade.php: Group cards dengan background photo
- ✅ events.blade.php: Event cards dengan photo overlay
- ✅ event-detail.blade.php: Dynamic event details dari database

### 4. **Routes & Controllers**
- ✅ Route `/event/{id}` diupdate untuk fetch event data dengan relations

---

## 🚀 Steps Untuk Menyelesaikan Setup

### **STEP 1: Buat Database MySQL**

Buka terminal dan jalankan:

```bash
# Masuk ke MySQL
mysql -u root

# Buat database
CREATE DATABASE sbd_kel_tubes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Keluar
EXIT;
```

Atau gunakan MySQL GUI tool seperti PhpMyAdmin di Laragon.

### **STEP 2: Fresh Migration (Recreate Tables)**

Jalankan command di terminal project:

```bash
cd c:\laragon\www\SBD-KEL-TUBES

# Jalankan fresh migration (warning: ini akan hapus semua data lama!)
php artisan migrate:fresh

# Jika ada error, coba:
php artisan migrate:fresh --force
```

### **STEP 3: Seed Database dengan Data**

```bash
# Jalankan semua seeders
php artisan db:seed

# Atau jalankan seeders dengan output:
php artisan db:seed --verbose
```

### **STEP 4: Verifikasi Migrations Berhasil**

Check apakah semua tables sudah created:

```bash
# Lihat semua tables di database
mysql -u root -e "USE sbd_kel_tubes; SHOW TABLES;"
```

Expected tables:
- users
- group_list
- group_detail
- event_list
- event_detail
- member_group
- event_attendance
- event_hosts
- group_topic
- topics
- reviews
- migrations

---

## 🖼️ Setup Photo URLs di Database

Photo URLs disimpan di field `event_photo` (events) dan `group_photo` (groups).

### Format Photo URL:
- Full URL: `https://example.com/photos/event-123.jpg`
- Relative path: `/storage/photos/event-123.jpg`
- Base64: `data:image/png;base64,...`

### Update Photo URLs (Optional):

Jika ingin update photo URLs di seeder data:

**1. Edit `database/seeders/groups_data.json`:**
```json
{
  "id_group": 1,
  "group_name": "Tech Meetup",
  "group_photo": "https://via.placeholder.com/400x300?text=Tech+Meetup",
  ...
}
```

**2. Edit `database/seeders/events_data.json`:**
```json
{
  "id": 1,
  "event_title": "Web Development Workshop",
  "event_photo": "https://via.placeholder.com/600x400?text=Web+Dev+Workshop",
  ...
}
```

**3. Jalankan seeder ulang:**
```bash
php artisan migrate:fresh --seed
```

---

## 🧪 Testing & Verification

### **Test 1: Check Home Page (Featured Groups & Events)**
```
URL: http://localhost/SBD-KEL-TUBES
Verify:
- ✓ Featured groups menampilkan photos
- ✓ Upcoming events menampilkan photos
- ✓ Placeholder muncul jika no photo di DB
```

### **Test 2: Check Groups Listing**
```
URL: http://localhost/SBD-KEL-TUBES/groups
Verify:
- ✓ Semua group cards punya background photo
- ✓ Photo display sebagai background image
- ✓ Paging berfungsi
```

### **Test 3: Check Events Listing**
```
URL: http://localhost/SBD-KEL-TUBES/events
Verify:
- ✓ Events tampil dengan photo sebagai background
- ✓ Date badge overlay di top-right
- ✓ Semua event info terlihat
```

### **Test 4: Check Event Details**
```
URL: http://localhost/SBD-KEL-TUBES/event/{id}
(Ganti {id} dengan event ID dari database, misal: 1)
Verify:
- ✓ Event photo tampil di hero section
- ✓ Event title, date, location dinamis dari DB
- ✓ Event description tampil dengan benar
- ✓ Group name dan info terlihat
```

---

## 🔧 Troubleshooting

### **Error: "Access denied for user 'root'@'localhost'"**
→ Update `.env` dengan password yang benar

### **Error: "Database 'sbd_kel_tubes' doesn't exist"**
→ Jalankan: `CREATE DATABASE sbd_kel_tubes;` di MySQL

### **Error: "Table 'event_list' doesn't exist"**
→ Jalankan: `php artisan migrate:fresh`

### **Photos tidak muncul di view**
Check:
1. Database field ada: `event_photo`, `group_photo`
2. Data sudah di-seed dengan photo URLs
3. Photo URLs valid (buka di browser langsung)
4. Model accessor `photo_url` working

### **Test Photo Accessor** (di Tinker):
```bash
php artisan tinker
>>> $event = App\Models\Event::first();
>>> $event->photo_url  // Should return URL
>>> exit
```

---

## 📊 Database Schema

### **group_list Table**
```sql
- id_group (primary key)
- group_name
- group_description
- city
- country
- group_photo ← PHOTO URL
- average_rating
- category
- is_newgroup
- member_count
- timestamps
```

### **event_list Table**
```sql
- id_event (primary key)
- id_group (foreign key)
- event_title
- event_description
- event_photo ← PHOTO URL
- event_type
- event_date
- total_rsvps
- venue_name
- venue_city
- venue_country
- category
- timestamps
```

---

## ✨ Features yang Sekarang Berfungsi

1. **Photo Display di Homepage**
   - Featured groups dengan group photos
   - Upcoming events dengan event photos

2. **Photo Display di Groups Page**
   - Semua groups dengan background photo
   - Fallback ke placeholder jika no photo

3. **Photo Display di Events Page**
   - Events dengan photo background
   - Date overlay tetap visible

4. **Dynamic Event Details**
   - Photo di hero section
   - Info dinamis dari database
   - Group info terintegrasi

5. **Fallback & Error Handling**
   - Auto placeholder jika photo URL kosong
   - Graceful degradation

---

## 🔄 Next Steps (Optional Enhancements)

1. **Setup Photo Upload**
   - Terima file upload untuk photo
   - Store di `storage/app/public/photos/`
   - Generate URLs otomatis

2. **Add User Photos**
   - Add `photo` field ke table users
   - Display member avatars di reviews

3. **Advanced Caching**
   - Cache photos dengan Laravel cache
   - Reduce database queries

4. **Image Optimization**
   - Resize photos saat upload
   - Generate thumbnails

---

**Created:** 2026-05-13
**Status:** Ready for Testing
