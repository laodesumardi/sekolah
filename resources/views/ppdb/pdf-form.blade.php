<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran PPDB - {{ $registration->registration_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            font-size: 18px;
            margin: 0;
            color: #2c3e50;
        }
        
        .header h2 {
            font-size: 14px;
            margin: 5px 0;
            color: #7f8c8d;
        }
        
        .form-section {
            margin-bottom: 25px;
        }
        
        .section-title {
            background-color: #3498db;
            color: white;
            padding: 8px 12px;
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 15px;
        }
        
        .form-row {
            display: flex;
            margin-bottom: 10px;
        }
        
        .form-group {
            flex: 1;
            margin-right: 15px;
        }
        
        .form-group:last-child {
            margin-right: 0;
        }
        
        .form-label {
            font-weight: bold;
            margin-bottom: 3px;
            display: block;
        }
        
        .form-value {
            border-bottom: 1px solid #333;
            padding: 3px 0;
            min-height: 18px;
        }
        
        .full-width {
            width: 100%;
        }
        
        .registration-info {
            background-color: #f8f9fa;
            padding: 15px;
            border: 1px solid #dee2e6;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .registration-number {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
        }
        
        .registration-date {
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
            padding-top: 15px;
        }
        
        .signature-section {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
        
        .signature-box {
            width: 200px;
            text-align: center;
        }
        
        .signature-line {
            border-bottom: 1px solid #333;
            height: 40px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>FORMULIR PENDAFTARAN PESERTA DIDIK BARU (PPDB)</h1>
        <h2>SMP NEGERI 01 NAMROLE</h2>
        <h2>TAHUN AJARAN 2024/2025</h2>
    </div>

    <div class="registration-info">
        <div class="registration-number">Nomor Pendaftaran: {{ $registration->registration_number }}</div>
        <div class="registration-date">Tanggal Pendaftaran: {{ $registration->created_at->format('d F Y') }}</div>
    </div>

    <!-- Data Siswa -->
    <div class="form-section">
        <div class="section-title">I. DATA SISWA</div>
        
        <div class="form-row">
            <div class="form-group">
                <span class="form-label">Nama Lengkap</span>
                <div class="form-value">{{ $registration->student_name }}</div>
            </div>
            <div class="form-group">
                <span class="form-label">Jenis Kelamin</span>
                <div class="form-value">{{ $registration->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <span class="form-label">Tempat, Tanggal Lahir</span>
                <div class="form-value">{{ $registration->birth_place }}, {{ $registration->birth_date->format('d F Y') }}</div>
            </div>
            <div class="form-group">
                <span class="form-label">Agama</span>
                <div class="form-value">{{ $registration->religion }}</div>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group full-width">
                <span class="form-label">Alamat Lengkap</span>
                <div class="form-value">{{ $registration->address }}</div>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <span class="form-label">No. Telepon/HP</span>
                <div class="form-value">{{ $registration->phone_number }}</div>
            </div>
            <div class="form-group">
                <span class="form-label">Email</span>
                <div class="form-value">{{ $registration->email ?? '-' }}</div>
            </div>
        </div>
    </div>

    <!-- Data Orang Tua -->
    <div class="form-section">
        <div class="section-title">II. DATA ORANG TUA/WALI</div>
        
        <div class="form-row">
            <div class="form-group">
                <span class="form-label">Nama Orang Tua/Wali</span>
                <div class="form-value">{{ $registration->parent_name }}</div>
            </div>
            <div class="form-group">
                <span class="form-label">No. Telepon/HP</span>
                <div class="form-value">{{ $registration->parent_phone }}</div>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group full-width">
                <span class="form-label">Pekerjaan Orang Tua/Wali</span>
                <div class="form-value">{{ $registration->parent_occupation }}</div>
            </div>
        </div>
    </div>

    <!-- Data Sekolah Asal -->
    <div class="form-section">
        <div class="section-title">III. DATA SEKOLAH ASAL</div>
        
        <div class="form-row">
            <div class="form-group full-width">
                <span class="form-label">Nama Sekolah Asal</span>
                <div class="form-value">{{ $registration->previous_school ?? '-' }}</div>
            </div>
        </div>
    </div>

    <!-- Prestasi dan Motivasi -->
    <div class="form-section">
        <div class="section-title">IV. PRESTASI DAN MOTIVASI</div>
        
        <div class="form-row">
            <div class="form-group full-width">
                <span class="form-label">Prestasi yang Pernah Dicapai</span>
                <div class="form-value" style="min-height: 40px;">{{ $registration->achievements ?? '-' }}</div>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group full-width">
                <span class="form-label">Motivasi Masuk SMP Negeri 01 Namrole</span>
                <div class="form-value" style="min-height: 40px;">{{ $registration->motivation ?? '-' }}</div>
            </div>
        </div>
    </div>

    <!-- Dokumen -->
    <div class="form-section">
        <div class="section-title">V. DOKUMEN YANG DILAMPIRKAN</div>
        
        <div class="form-row">
            <div class="form-group">
                <span class="form-label">Foto Siswa</span>
                <div class="form-value">{{ $registration->photo ? '✓ Dilampirkan' : '✗ Tidak ada' }}</div>
            </div>
            <div class="form-group">
                <span class="form-label">Akta Kelahiran</span>
                <div class="form-value">{{ $registration->birth_certificate ? '✓ Dilampirkan' : '✗ Tidak ada' }}</div>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <span class="form-label">Kartu Keluarga</span>
                <div class="form-value">{{ $registration->family_card ? '✓ Dilampirkan' : '✗ Tidak ada' }}</div>
            </div>
            <div class="form-group">
                <span class="form-label">Raport</span>
                <div class="form-value">{{ $registration->report_card ? '✓ Dilampirkan' : '✗ Tidak ada' }}</div>
            </div>
        </div>
    </div>

    <!-- Status Pendaftaran -->
    <div class="form-section">
        <div class="section-title">VI. STATUS PENDAFTARAN</div>
        
        <div class="form-row">
            <div class="form-group">
                <span class="form-label">Status</span>
                <div class="form-value">
                    @if($registration->status == 'pending')
                        Menunggu Review
                    @elseif($registration->status == 'approved')
                        Diterima
                    @elseif($registration->status == 'rejected')
                        Ditolak
                    @else
                        {{ ucfirst($registration->status) }}
                    @endif
                </div>
            </div>
            <div class="form-group">
                <span class="form-label">Catatan</span>
                <div class="form-value">{{ $registration->notes ?? '-' }}</div>
            </div>
        </div>
    </div>

    <!-- Tanda Tangan -->
    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-line"></div>
            <div>Orang Tua/Wali</div>
            <div style="margin-top: 20px;">({{ $registration->parent_name }})</div>
        </div>
        
        <div class="signature-box">
            <div class="signature-line"></div>
            <div>Panitia PPDB</div>
            <div style="margin-top: 20px;">(___________________)</div>
        </div>
    </div>

    <div class="footer">
        <p>Formulir ini dicetak pada: {{ now()->format('d F Y H:i') }}</p>
        <p>SMP Negeri 01 Namrole - Tahun Ajaran 2024/2025</p>
    </div>
</body>
</html>
