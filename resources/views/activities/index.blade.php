<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskVibe - Dashboard</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            background: #050a14;
        }

        /* ===== BACKGROUND MEWAH ===== */
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #f1f5f9;
            min-height: 100vh;
            background-color: #050a14;
            background-image:
                radial-gradient(900px 500px at 90% -10%, rgba(212, 175, 55, 0.22), transparent 60%),
                radial-gradient(1000px 600px at 5% 105%, rgba(20, 184, 166, 0.25), transparent 60%),
                radial-gradient(800px 500px at 50% 40%, rgba(14, 116, 144, 0.18), transparent 70%),
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(160deg, #060d1b 0%, #0a1628 50%, #04070f 100%);
            background-size: auto, auto, auto, 48px 48px, 48px 48px, auto;
            background-attachment: fixed;
        }

        /* Vignette */
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            background: radial-gradient(ellipse at center, transparent 55%, rgba(0, 0, 0, 0.55) 100%);
        }

        /* Orb cahaya bergerak */
        body::after {
            content: "";
            position: fixed;
            width: 520px;
            height: 520px;
            top: 10%;
            left: 55%;
            pointer-events: none;
            z-index: 0;
            background: radial-gradient(circle, rgba(34, 211, 238, 0.16), transparent 65%);
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

        button, input, textarea {
            font-family: inherit;
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 245px;
            background: linear-gradient(180deg, rgba(10, 18, 36, 0.75) 0%, rgba(5, 10, 20, 0.85) 100%);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-right: 1px solid rgba(212, 175, 55, 0.18);
            box-shadow: 4px 0 40px rgba(0, 0, 0, 0.45),
                        inset -1px 0 0 rgba(34, 211, 238, 0.08);
            color: white;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
        }

        .logo {
            font-size: 25px;
            font-weight: 800;
            margin-bottom: 55px;
            color: white;
            letter-spacing: 0.5px;
            text-shadow: 0 0 24px rgba(34, 211, 238, 0.35);
        }

        .logo span {
            color: #20d5d0;
            text-shadow: 0 0 18px rgba(32, 213, 208, 0.7);
        }

        .menu-title {
            font-size: 11px;
            color: #b8a25a;
            margin-bottom: 15px;
            letter-spacing: 2px;
        }

        .menu a {
            display: block;
            text-decoration: none;
            color: #aab6c8;
            padding: 14px;
            border-radius: 12px;
            margin-bottom: 9px;
            border: 1px solid transparent;
            transition: all .25s ease;
        }

        .menu a:hover {
            background: rgba(34, 211, 238, 0.08);
            border-color: rgba(34, 211, 238, 0.25);
            color: #e6fbff;
            transform: translateX(4px);
        }

        .menu a.active {
            background: linear-gradient(90deg, #06b6d4, #25d4bd);
            color: #06121f;
            font-weight: 700;
            box-shadow: 0 6px 24px rgba(6, 182, 212, 0.35),
                        0 0 0 1px rgba(212, 175, 55, 0.25);
        }

        .sidebar-bottom {
            margin-top: auto;
        }

        .logout-button {
            width: 100%;
            padding: 13px;
            border: 1px solid rgba(212, 175, 55, 0.35);
            background: rgba(6, 182, 212, 0.05);
            color: #22d3ee;
            border-radius: 10px;
            cursor: pointer;
            transition: all .25s ease;
        }

        .logout-button:hover {
            background: linear-gradient(90deg, #06b6d4, #25d4bd);
            color: #06121f;
            border-color: transparent;
            box-shadow: 0 6px 24px rgba(6, 182, 212, 0.35);
        }

        /* ===== MAIN ===== */
        .main {
            flex: 1;
            padding: 35px 45px;
            min-width: 0;
            background: transparent;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 35px;
        }

        .topbar h1 {
            font-size: 27px;
            margin-bottom: 7px;
        }

        .topbar p {
            color: #94a3b8;
            font-size: 14px;
        }

        .user-badge {
            background: rgba(15, 25, 45, 0.55);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            color: #22d3ee;
            border: 1px solid rgba(212, 175, 55, 0.3);
            padding: 12px 18px;
            border-radius: 14px;
            font-weight: 600;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.35);
        }

        /* ===== GAMIFIKASI (level, streak, XP) ===== */
        .gamify {
            background: linear-gradient(135deg, rgba(13, 148, 136, 0.18), rgba(6, 182, 212, 0.14));
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(212, 175, 55, 0.3);
            padding: 20px;
            border-radius: 16px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.35),
                        0 0 20px rgba(6, 182, 212, 0.1);
        }

        .gamify-badges {
            display: flex;
            gap: 10px;
            margin-bottom: 8px;
        }

        .badge {
            font-size: 11px;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: bold;
        }

        .badge-level {
            background: rgba(212, 175, 55, 0.15);
            color: #f3d97a;
            border: 1px solid rgba(212, 175, 55, 0.5);
        }

        .badge-streak {
            background: rgba(249, 115, 22, 0.2);
            color: #fb923c;
            border: 1px solid rgba(249, 115, 22, 0.4);
        }

        .gamify h3 {
            color: #ffffff;
            font-size: 18px;
            font-weight: bold;
            margin: 0 0 4px 0;
        }

        .gamify p {
            color: #94a3b8;
            font-size: 13px;
            margin: 0;
        }

        .xp-box {
            background: rgba(5, 10, 20, 0.6);
            border: 1px solid rgba(6, 182, 212, 0.25);
            padding: 12px 16px;
            border-radius: 12px;
            min-width: 220px;
        }

        .xp-info {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-bottom: 6px;
            color: #cbd5e1;
            font-weight: 600;
        }

        .xp-info .xp-value {
            color: #22d3ee;
        }

        .xp-track {
            width: 100%;
            background: rgba(255, 255, 255, 0.08);
            height: 8px;
            border-radius: 9999px;
            overflow: hidden;
        }

        .xp-fill {
            background: linear-gradient(90deg, #d4af37, #22d3ee, #14b8a6);
            height: 100%;
            transition: width 0.5s ease;
        }

        /* ===== WELCOME ===== */
        .welcome-card {
            background: linear-gradient(120deg, #0e7490, #0891b2, #14b8a6);
            color: white;
            border: 1px solid rgba(212, 175, 55, 0.4);
            box-shadow: 0 12px 50px rgba(6, 182, 212, 0.25),
                        0 0 0 1px rgba(212, 175, 55, 0.15);
            border-radius: 22px;
            padding: 30px;
            margin-bottom: 25px;
            position: relative;
            overflow: hidden;
        }

        .welcome-card h2 {
            font-size: 25px;
            margin-bottom: 10px;
        }

        .welcome-card p {
            color: #d9faff;
            line-height: 1.7;
            font-size: 14px;
        }

        .welcome-decoration {
            position: absolute;
            right: 35px;
            top: 15px;
            font-size: 85px;
            opacity: .2;
        }

        /* ===== STATISTIK ===== */
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 25px;
        }

        .stat-card,
        .card {
            background: linear-gradient(145deg, rgba(20, 32, 56, 0.6), rgba(10, 18, 36, 0.55));
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4),
                        inset 0 1px 0 rgba(255, 255, 255, 0.06);
            transition: transform .25s ease, border-color .25s ease;
        }

        .stat-card:hover,
        .card:hover {
            transform: translateY(-3px);
            border-color: rgba(212, 175, 55, 0.35);
        }

        .stat-card {
            border-radius: 18px;
            padding: 23px;
        }

        .stat-card small {
            color: #94a3b8;
            font-size: 13px;
        }

        .stat-card h2 {
            color: #f8fafc;
            font-size: 30px;
            margin: 12px 0 5px;
        }

        .stat-card .icon {
            font-size: 25px;
        }

        .purple { color: #22d3ee; }
        .green  { color: #2dd4bf; }
        .orange { color: #fbbf24; }

        /* ===== CONTENT ===== */
        .content-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 22px;
            align-items: start;
        }

        .card {
            padding: 25px;
            border-radius: 18px;
            margin-bottom: 22px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 22px;
        }

        .card-header h3 {
            font-size: 17px;
        }

        .card-header span {
            color: #94a3b8;
            font-size: 12px;
        }

        /* ===== PROGRESS ===== */
        .progress-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 13px;
            gap: 10px;
        }

        .progress-track {
            width: 100%;
            height: 11px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #06b6d4, #2dd4bf);
            box-shadow: 0 0 12px #06b6d480;
            border-radius: 20px;
            transition: width .3s;
        }

        /* ===== FORM ===== */
        .add-form {
            display: grid;
            gap: 13px;
        }

        .add-form input,
        .add-form textarea {
            width: 100%;
            padding: 13px 15px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 11px;
            outline: none;
            font-size: 14px;
            background: rgba(5, 10, 20, 0.6);
            color: #f1f5f9;
        }

        .add-form input::placeholder,
        .add-form textarea::placeholder {
            color: #64748b;
        }

        .add-form input:focus,
        .add-form textarea:focus {
            border-color: #06b6d4;
            box-shadow: 0 0 0 2px #06b6d420;
        }

        .add-form textarea {
            resize: vertical;
            min-height: 75px;
        }

        .add-form label {
            color: #cbd5e1;
        }

        .primary-button {
            background: linear-gradient(90deg, #06b6d4, #22d3b9);
            color: #06121f;
            border: none;
            padding: 14px;
            border-radius: 11px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 0 18px #06b6d430;
            transition: .2s;
        }

        .primary-button:hover {
            background: linear-gradient(90deg, #0891b2, #0d9488);
        }

        /* ===== DAFTAR AKTIVITAS ===== */
        .activity-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            padding: 17px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-info {
            min-width: 0;
        }

        .activity-info strong {
            display: block;
            color: #f1f5f9;
            font-size: 14px;
            margin-bottom: 6px;
            overflow-wrap: anywhere;
        }

        .activity-info small {
            color: #94a3b8;
            font-size: 12px;
        }

        .done {
            text-decoration: line-through;
            color: #64748b !important;
        }

        .activity-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 6px;
        }

        .action-button {
            border: none;
            padding: 8px 10px;
            border-radius: 8px;
            font-size: 11px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .edit-button {
            background: #123047;
            color: #38bdf8;
        }

        .done-button {
            background: #103b3b;
            color: #2dd4bf;
        }

        .delete-button {
            background: #451e2a;
            color: #fb7185;
        }

        .action-button:hover {
            filter: brightness(1.2);
        }

        .activity-actions form {
            display: inline;
        }

        .empty-state {
            text-align: center;
            padding: 30px 10px;
            color: #94a3b8;
            font-size: 14px;
        }

        .empty-state div {
            font-size: 35px;
            margin-bottom: 10px;
        }

        /* ===== NOTIFIKASI ===== */
        .success {
            background: #103b36;
            color: #5eead4;
            border: 1px solid #0f766e;
            padding: 13px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .error {
            color: #fda4af;
            font-size: 12px;
        }

        /* ===== MOTIVASI ===== */
        .card p {
            color: #94a3b8;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 900px) {
            .main {
                padding: 25px;
            }

            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 650px) {
            .dashboard {
                display: block;
            }

            .sidebar {
                width: 100%;
                padding: 18px;
            }

            .logo {
                margin-bottom: 20px;
            }

            .menu-title,
            .sidebar-bottom {
                display: none;
            }

            .menu {
                display: flex;
                gap: 7px;
                overflow-x: auto;
            }

            .menu a {
                white-space: nowrap;
                margin: 0;
                padding: 10px;
                font-size: 13px;
            }

            .main {
                padding: 20px 15px;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .topbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .welcome-decoration {
                right: 15px;
                font-size: 60px;
            }

            .activity-item {
                align-items: flex-start;
                flex-direction: column;
            }

            .activity-actions {
                justify-content: flex-start;
            }
        }
    </style>
</head>

<body>

@php
    $pending = $total - $done;
    $percentage = $total > 0 ? round(($done / $total) * 100) : 0;
@endphp

<div class="dashboard">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="logo">
            TASK<span>VIBE.</span>
        </div>

        <div class="menu-title">MENU UTAMA</div>

        <nav class="menu">
            <a href="#dashboard" class="active">⌂ Dashboard</a>
            <a href="#aktivitas">▣ Aktivitas</a>
            <a href="#tambah">＋ Tambah Pengingat</a>
        </nav>

        <div class="sidebar-bottom">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-button">
                    ↪ Logout
                </button>
            </form>
        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="main" id="dashboard">

        <!-- HEADER -->
        <header class="topbar">
            <div>
                <h1>Dashboard</h1>
                <p>Kelola aktivitas dan produktivitas harianmu.</p>
            </div>

            <div class="user-badge">
                👋 Halo, {{ auth()->user()->name }}
            </div>
        </header>

        <!-- GAMIFIKASI -->
        @php
            $currentExp = auth()->user()->exp ?? 0;
            $expInCurrentLevel = $currentExp % 100;
        @endphp

        <div class="gamify">
            <div>
                <div class="gamify-badges">
                    <span class="badge badge-level">
                        ⭐ Level {{ auth()->user()->level ?? 1 }}
                    </span>
                    <span class="badge badge-streak">
                        🔥 Streak: {{ auth()->user()->streak_count ?? 0 }} Hari
                    </span>
                </div>
                <h3>Misi Operator: {{ auth()->user()->name }}</h3>
                <p>Selesaikan tugas di bawah untuk menambah XP dan menaikkan level!</p>
            </div>

            <div class="xp-box">
                <div class="xp-info">
                    <span>XP Progress</span>
                    <span class="xp-value">{{ $expInCurrentLevel }} / 100 XP</span>
                </div>
                <div class="xp-track">
                    <div class="xp-fill" style="width: {{ $expInCurrentLevel }}%;"></div>
                </div>
            </div>
        </div>

        <!-- WELCOME -->
        <section class="welcome-card">
            <div class="welcome-decoration">🏆</div>

            <h2>Selamat Datang Kembali! 👋</h2>

            <p>
                Setiap langkah kecil membawa kamu lebih dekat
                dengan tujuanmu. Yuk, selesaikan aktivitas hari ini!
            </p>
        </section>

        <!-- SUCCESS MESSAGE -->
        @if (session('success'))
            <div class="success">
                ✓ {{ session('success') }}
            </div>
        @endif

        <!-- VALIDATION ERROR -->
        @if ($errors->any())
            <div class="success" style="background:#451e2a;color:#fda4af;">
                <strong>Periksa kembali data yang dimasukkan:</strong>

                @foreach ($errors->all() as $error)
                    <div class="error">{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- STATISTICS -->
        <section class="stats">

            <div class="stat-card">
                <div class="icon purple">▣</div>
                <small>Total Aktivitas</small>
                <h2>{{ $total }}</h2>
                <small>Semua pengingat</small>
            </div>

            <div class="stat-card">
                <div class="icon green">✓</div>
                <small>Sudah Selesai</small>
                <h2>{{ $done }}</h2>
                <small>Aktivitas terselesaikan</small>
            </div>

            <div class="stat-card">
                <div class="icon orange">◷</div>
                <small>Belum Selesai</small>
                <h2>{{ $pending }}</h2>
                <small>Aktivitas tersisa</small>
            </div>

        </section>

        <!-- CONTENT GRID -->
        <section class="content-grid">

            <div>

                <!-- PROGRESS -->
                <div class="card">

                    <div class="card-header">
                        <h3>Progress Aktivitas</h3>
                        <span>{{ $percentage }}%</span>
                    </div>

                    <div class="progress-info">
                        <span>{{ $done }} dari {{ $total }} aktivitas selesai</span>
                        <strong>{{ $percentage }}%</strong>
                    </div>

                    <div class="progress-track">
                        <div class="progress-fill"
                             style="width: {{ $percentage }}%;">
                        </div>
                    </div>

                </div>

                <!-- ACTIVITY LIST -->
                <div class="card" id="aktivitas">

                    <div class="card-header">
                        <h3>Daftar Aktivitas</h3>
                        <span>{{ $total }} aktivitas</span>
                    </div>

                    @forelse ($activities as $activity)

                        <div class="activity-item">

                            <div class="activity-info">

                                <strong class="{{ $activity->is_done ? 'done' : '' }}">
                                    {{ $activity->name }}
                                </strong>

                                <small>
                                    ◷ Pukul {{ substr($activity->remind_at, 0, 5) }}
                                </small>

                                @if ($activity->description)
                                    <br>
                                    <small>{{ $activity->description }}</small>
                                @endif

                            </div>

                            <div class="activity-actions">

                                <a href="{{ route('activities.edit', $activity) }}"
                                   class="action-button edit-button">
                                    Edit
                                </a>

                                <form method="POST"
                                      action="{{ route('activities.toggle', $activity) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" class="action-button done-button">
                                        {{ $activity->is_done ? 'Batal' : 'Selesai' }}
                                    </button>
                                </form>

                                <form method="POST"
                                      action="{{ route('activities.destroy', $activity) }}"
                                      onsubmit="return confirm('Yakin ingin menghapus aktivitas ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="action-button delete-button">
                                        Hapus
                                    </button>
                                </form>

                            </div>

                        </div>

                    @empty

                        <div class="empty-state">
                            <div>📝</div>
                            <strong>Belum Ada Aktivitas</strong>
                            <p>Tambahkan pengingat pertamamu sekarang!</p>
                        </div>

                    @endforelse

                </div>

            </div>

            <!-- ADD ACTIVITY -->
            <div>

                <div class="card" id="tambah">

                    <div class="card-header">
                        <h3>Tambah Pengingat</h3>
                        <span>＋ Baru</span>
                    </div>

                    <form class="add-form"
                          method="POST"
                          action="{{ route('activities.store') }}">

                        @csrf

                        <label>
                            <small>Nama Aktivitas</small>
                        </label>

                        <input
                            type="text"
                            name="name"
                            placeholder="Contoh: Belajar Laravel"
                            value="{{ old('name') }}"
                            required
                        >

                        <label>
                            <small>Deskripsi</small>
                        </label>

                        <textarea
                            name="description"
                            placeholder="Tambahkan deskripsi (opsional)"
                        >{{ old('description') }}</textarea>

                        <label>
                            <small>Waktu Pengingat</small>
                        </label>

                        <input
                            type="time"
                            name="remind_at"
                            value="{{ old('remind_at') }}"
                            required
                        >

                        <button type="submit" class="primary-button">
                            + Tambah Pengingat
                        </button>

                    </form>

                </div>

                <!-- MOTIVATION -->
                <div class="card">

                    <div class="card-header">
                        <h3>Daily Reminder ✨</h3>
                    </div>

                    <p style="font-size:14px;line-height:1.8;">
                        "Produktivitas bukan tentang melakukan semuanya
                        sekaligus, tetapi tentang menyelesaikan satu hal
                        dengan baik."
                    </p>

                    <br>

                    <strong class="purple">Keep Going!</strong>

                </div>

            </div>

        </section>

    </main>

</div>

</body>
</html>
