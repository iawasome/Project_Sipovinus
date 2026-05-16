<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Laporan Program Kerja' }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111827; }
        .header { text-align: center; margin-bottom: 16px; }
        .header h1 { font-size: 18px; margin: 0; }
        .sub { margin-top: 6px; color: #374151; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #e5e7eb; padding: 8px; vertical-align: top; }
        th { background: #f9fafb; text-align: left; }
        .section-title { margin: 18px 0 8px; font-size: 14px; font-weight: 700; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 999px; background: #eef2ff; color: #3730a3; font-weight: 700; font-size: 12px; }
        .grid2 { width: 100%; }
        .grid2 td { width: 50%; }
        .muted { color: #6b7280; }
        .small { font-size: 11px; }
        .footer { margin-top: 24px; font-size: 11px; color: #6b7280; text-align: right; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Sipovinus - Laporan Program Kerja</h1>
        <div class="sub">ITB Vinus • Generated: {{ now()->format('d M Y') }}</div>
    </div>

    <table>
        <tr>
            <th style="width:25%">Nama Proker</th>
            <td>{{ $proker->name }}</td>
            <th style="width:25%">Divisi</th>
            <td>{{ $proker->division?->name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                <span class="badge">{{ $proker->status }}</span>
            </td>
            <th>Progres</th>
            <td>{{ $proker->progress }}%</td>
        </tr>
        <tr>
            <th>Periode</th>
            <td colspan="3">
                {{ $proker->start_date }} s/d {{ $proker->end_date }}
            </td>
        </tr>
        <tr>
            <th>Estimasi Anggaran</th>
            <td colspan="3">
                @php
                    $budget = $proker->budget_estimate;
                @endphp
                {{ is_numeric($budget) ? number_format((float)$budget, 0, ',', '.') : '-' }}
            </td>
        </tr>
    </table>

    @if(!empty($tasks))
        <div class="section-title">Daftar Task</div>
        <table>
            <thead>
                <tr>
                    <th style="width:5%">No</th>
                    <th>Nama Task</th>
                    <th style="width:20%">Due Date</th>
                    <th style="width:20%">Status</th>
                </tr>
            </thead>
            <tbody>
            @foreach($tasks as $i => $task)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $task->task_name }}</td>
                    <td>{{ $task->due_date }}</td>
                    <td>
                        {{ $task->is_completed ? 'Selesai' : 'Belum Selesai' }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="section-title">Daftar Task</div>
        <div class="muted">Tidak ada data task untuk proker ini.</div>
    @endif

    @if(!empty($anggarans))
        <div class="section-title">Ringkasan Anggaran</div>
        <table>
            <thead>
                <tr>
                    <th style="width:5%">No</th>
                    <th>Nama</th>
                    <th style="width:30%">Estimasi / Nilai</th>
                    <th style="width:25%">Tanggal</th>
                </tr>
            </thead>
            <tbody>
            @foreach($anggarans as $i => $anggaran)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $anggaran->name ?? '-' }}</td>
                    <td>{{ number_format((float)($anggaran->amount ?? $anggaran->budget ?? $proker->budget_estimate ?? 0), 0, ',', '.') }}</td>
                    <td>{{ $anggaran->date ?? '-' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="section-title">Ringkasan Anggaran</div>
        <div class="muted">Tidak ada data anggaran untuk proker ini.</div>
    @endif

    <div class="footer">© {{ date('Y') }} Sipovinus - ITB Vinus. All rights reserved.</div>
</body>
</html>

