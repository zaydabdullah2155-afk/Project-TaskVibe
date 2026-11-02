<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengingat - TaskVibe</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 40px auto; padding: 0 16px; }
        form { display: grid; gap: 8px; }
        input, textarea, button { padding: 8px; font-size: 14px; }
    </style>
</head>
<body>
    <h1>Edit Pengingat</h1>

    <form method="POST" action="{{ route('activities.update', $activity) }}">
        @csrf
        @method('PUT')
        <input type="text" name="name" value="{{ old('name', $activity->name) }}" required>
        <textarea name="description">{{ old('description', $activity->description) }}</textarea>
        <input type="time" name="remind_at" value="{{ old('remind_at', substr($activity->remind_at, 0, 5)) }}" required>
        <button type="submit">Simpan</button>
    </form>

    <p><a href="{{ route('activities.index') }}">← Kembali</a></p>
</body>
</html>