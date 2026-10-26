<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskVibe - Pengingat Harian</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 40px auto; padding: 0 16px; }
        form.add { display: grid; gap: 8px; margin-bottom: 24px; }
        input, textarea, button { padding: 8px; font-size: 14px; }
        .item { display: flex; justify-content: space-between; align-items: center; padding: 10px; border: 1px solid #ddd; border-radius: 6px; margin-bottom: 8px; }
        .done { text-decoration: line-through; color: #888; }
        .success { background: #e6ffed; padding: 8px; border-radius: 6px; margin-bottom: 12px; }
        .actions form { display: inline; }
    </style>
</head>
<body>
    <h1>Pengingat Aktivitas Harian</h1>

    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <form class="add" method="POST" action="{{ route('activities.store') }}">
        @csrf
        <input type="text" name="name" placeholder="Nama aktivitas" required>
        <textarea name="description" placeholder="Deskripsi (opsional)"></textarea>
        <input type="time" name="remind_at" required>
        <button type="submit">Tambah Pengingat</button>
    </form>

    @forelse ($activities as $activity)
        <div class="item">
            <div>
                <strong class="{{ $activity->is_done ? 'done' : '' }}">{{ $activity->name }}</strong>
                <br>
                <small>Pukul {{ substr($activity->remind_at, 0, 5) }}</small>
                @if ($activity->description)
                    <br><small>{{ $activity->description }}</small>
                @endif
            </div>
            <div class="actions">
                <form method="POST" action="{{ route('activities.toggle', $activity) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit">{{ $activity->is_done ? 'Batal' : 'Selesai' }}</button>
                </form>
                <form method="POST" action="{{ route('activities.destroy', $activity) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Hapus</button>
                </form>
            </div>
        </div>
    @empty
        <p>Belum ada pengingat. Tambahkan satu di atas.</p>
    @endforelse
</body>
</html>
