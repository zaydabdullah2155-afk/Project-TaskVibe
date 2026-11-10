<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Pengingat - TaskVibe</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #0b1220;
            color: #f8fafc;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .edit-container {
            width: 100%;
            max-width: 600px;
            background: #111c30;
            border: 1px solid #233650;
            border-radius: 18px;
            padding: 35px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        .edit-header {
            margin-bottom: 30px;
        }

        .edit-header h1 {
            font-size: 28px;
            color: #ffffff;
            margin-bottom: 10px;
        }

        .edit-header p {
            color: #94a3b8;
            font-size: 14px;
        }

        .edit-header span {
            color: #06b6d4;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            color: #cbd5e1;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 9px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 14px 16px;
            background: #080e1d;
            border: 1px solid #334155;
            border-radius: 10px;
            color: #ffffff;
            font-size: 14px;
            outline: none;
            transition: 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #06b6d4;
            box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.12);
        }

        .form-group textarea {
            min-height: 110px;
            resize: vertical;
        }

        .form-group input[type="time"] {
            color-scheme: dark;
        }

        .btn-simpan {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #06b6d4, #14b8a6);
            color: #06121d;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-simpan:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(6, 182, 212, 0.25);
        }

        .btn-kembali {
            display: inline-block;
            margin-top: 22px;
            color: #22d3ee;
            text-decoration: none;
            font-size: 14px;
            transition: 0.3s;
        }

        .btn-kembali:hover {
            color: #14b8a6;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid #ef4444;
            color: #fca5a5;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        @media (max-width: 600px) {
            .edit-container {
                padding: 25px 20px;
            }

            .edit-header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>

    <div class="edit-container">

        <div class="edit-header">
            <h1>Edit <span>Pengingat.</span></h1>
            <p>Perbarui aktivitas dan jadwal pengingat harianmu.</p>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('activities.update', $activity) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama Aktivitas</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $activity->name) }}"
                    placeholder="Contoh: Belajar Laravel"
                    required
                >
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea
                    name="description"
                    placeholder="Tambahkan deskripsi aktivitas..."
                >{{ old('description', $activity->description) }}</textarea>
            </div>

            <div class="form-group">
                <label>Waktu Pengingat</label>
                <input
                    type="time"
                    name="remind_at"
                    value="{{ old('remind_at', \Carbon\Carbon::parse($activity->remind_at)->format('H:i')) }}"
                    required
                >
            </div>

            <button type="submit" class="btn-simpan">
                Simpan Perubahan
            </button>

        </form>

        <a href="{{ route('activities.index') }}" class="btn-kembali">
            ← Kembali ke Dashboard
        </a>

    </div>

</body>
</html>