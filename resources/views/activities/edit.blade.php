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

        html {
            background: #050a14;
        }

        /* ===== BACKGROUND MEWAH (sama dengan dashboard) ===== */
        body {
            font-family: 'Segoe UI', sans-serif;
            color: #f8fafc;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background-color: #050a14;
            background-image:
                radial-gradient(900px 500px at 90% -10%, rgba(212, 175, 55, 0.18), transparent 60%),
                radial-gradient(1000px 600px at 5% 105%, rgba(20, 184, 166, 0.15), transparent 60%),
                radial-gradient(800px 500px at 50% 40%, rgba(14, 116, 144, 0.10), transparent 70%),
                linear-gradient(rgba(255, 255, 255, 0.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.025) 1px, transparent 1px),
                linear-gradient(180deg, rgba(5, 10, 20, 0.70) 0%, rgba(5, 10, 20, 0.55) 50%, rgba(5, 10, 20, 0.80) 100%),
                url('{{ asset("images/yul.jpg") }}');
            background-size: auto, auto, auto, 48px 48px, 48px 48px, auto, cover;
            background-position: center;
            background-attachment: fixed;
        }

        /* Vignette */
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            background: radial-gradient(ellipse at center, transparent 70%, rgba(0, 0, 0, 0.4) 100%);
        }

        /* Orb cahaya bergerak */
        body::after {
            content: "";
            position: fixed;
            width: 600px;
            height: 600px;
            top: 10%;
            left: 55%;
            pointer-events: none;
            z-index: 0;
            background: radial-gradient(circle, rgba(34, 211, 238, 0.2), transparent 65%);
            filter: blur(60px);
            animation: floatOrb 18s ease-in-out infinite alternate;
        }

        @keyframes floatOrb {
            from { transform: translate(0, 0) scale(1); }
            to   { transform: translate(-180px, 120px) scale(1.25); }
        }

        @media (prefers-reduced-motion: reduce) {
            body::after { animation: none; }
        }

        /* ===== KARTU EDIT ===== */
        .edit-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 600px;
            background: linear-gradient(145deg, rgba(25, 40, 70, 0.6), rgba(8, 14, 28, 0.6));
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(212, 175, 55, 0.28);
            border-top: 2px solid rgba(212, 175, 55, 0.75);
            border-radius: 18px;
            padding: 35px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5),
                        0 0 40px rgba(212, 175, 55, 0.1),
                        inset 0 1px 0 rgba(255, 255, 255, 0.06);
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
            background: linear-gradient(90deg, #f3d97a, #d4af37);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
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

        .form-group label small {
            color: #94a3b8;
            font-weight: 400;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 14px 16px;
            background: rgba(5, 10, 20, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 10px;
            color: #ffffff;
            font-size: 14px;
            font-family: inherit;
            outline: none;
            transition: 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #06b6d4;
            box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.15);
        }

        .form-group textarea {
            min-height: 110px;
            resize: vertical;
        }

        .form-group input[type="time"],
        .form-group input[type="datetime-local"] {
            color-scheme: dark;
        }

        .btn-simpan {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #d4af37, #22d3b9);
            color: #06121d;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 6px 25px rgba(212, 175, 55, 0.3);
        }

        .btn-simpan:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #f3d97a, #2dd4bf);
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.4);
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
            color: #f3d97a;
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
            <p>Perbarui aktivitas, jadwal pengingat, dan batas waktu selesai.</p>
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

            <div class="form-group">
                <label>Batas Waktu Selesai <small>(opsional)</small></label>
                <input
                    type="datetime-local"
                    name="deadline_at"
                    value="{{ old('deadline_at', $activity->deadline_at?->format('Y-m-d\TH:i')) }}"
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