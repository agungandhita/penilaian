<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #10B981; color: #fff; }
    </style>
    <title>Transkrip Nilai</title>
    </head>
<body>
    <h2>Transkrip Nilai</h2>
    <p>NIS: {{ $siswa->nis }}<br>Nama: {{ $siswa->nama_lengkap }}<br>Kelas: {{ $siswa->kelas->nama_kelas }}</p>
    <table>
        <thead>
            <tr>
                <th>Mata Pelajaran</th>
                <th>Tugas</th>
                <th>UH</th>
                <th>UTS</th>
                <th>UAS</th>
                <th>Nilai Akhir</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach($semuaNilai as $n)
            @php
                $na = (float)($n->nilai_akhir ?? 0);
                $grade = $na >= 85 ? 'A' : ($na >= 70 ? 'B' : ($na >= 55 ? 'C' : 'D'));
            @endphp
            <tr>
                <td>{{ $n->mataPelajaran->nama_mapel }}</td>
                <td>{{ $n->tugas ?? '-' }}</td>
                <td>{{ $n->ulangan_harian ?? '-' }}</td>
                <td>{{ $n->uts ?? '-' }}</td>
                <td>{{ $n->uas ?? '-' }}</td>
                <td>{{ number_format($n->nilai_akhir,2) }}</td>
                <td>{{ $grade }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
