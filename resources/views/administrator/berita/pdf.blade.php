<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <title>Laporan Data Berita</title>

    <style>
        @page {
            margin: 25px 30px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #1f2937;
            background: #ffffff;
        }

        .header {
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 12px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: middle;
        }

        .header-title {
            font-size: 20px;
            font-weight: bold;
            color: #172554;
            margin: 0 0 5px 0;
        }

        .header-subtitle {
            font-size: 10px;
            color: #64748b;
            margin: 0;
        }

        .generated-at {
            text-align: right;
            font-size: 9px;
            color: #64748b;
        }

        .summary {
            width: 100%;
            margin-bottom: 16px;
            border-collapse: collapse;
        }

        .summary td {
            width: 25%;
            padding: 10px 12px;
            border: 1px solid #dbe3ef;
            background: #f8fafc;
        }

        .summary-label {
            display: block;
            font-size: 8px;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 4px;
        }

        .summary-value {
            font-size: 12px;
            font-weight: bold;
            color: #172554;
        }

        .filter-box {
            margin-bottom: 16px;
            padding: 10px 12px;
            border: 1px solid #dbe3ef;
            background: #f8fafc;
        }

        .filter-title {
            font-size: 10px;
            font-weight: bold;
            color: #172554;
            margin-bottom: 7px;
        }

        .filter-table {
            width: 100%;
            border-collapse: collapse;
        }

        .filter-table td {
            padding: 3px 0;
            vertical-align: top;
        }

        .filter-label {
            width: 130px;
            color: #64748b;
        }

        .filter-value {
            color: #111827;
            font-weight: bold;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .data-table thead th {
            padding: 8px 6px;
            border: 1px solid #cbd5e1;
            background: #1e3a8a;
            color: #ffffff;
            font-size: 9px;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
        }

        .data-table tbody td {
            padding: 7px 6px;
            border: 1px solid #dbe3ef;
            vertical-align: middle;
            word-wrap: break-word;
        }

        .data-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .status {
            display: inline-block;
            padding: 3px 7px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }

        .status-active {
            color: #166534;
            background: #dcfce7;
            border: 1px solid #bbf7d0;
        }

        .status-inactive {
            color: #991b1b;
            background: #fee2e2;
            border: 1px solid #fecaca;
        }

        .no-data {
            padding: 30px 10px !important;
            text-align: center;
            color: #64748b;
            font-style: italic;
            background: #ffffff !important;
        }

        .footer {
            margin-top: 15px;
            padding-top: 8px;
            border-top: 1px solid #dbe3ef;
            font-size: 8px;
            color: #64748b;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-table td:last-child {
            text-align: right;
        }

        .col-no {
            width: 4%;
        }

        .col-tanggal {
            width: 10%;
        }

        .col-judul {
            width: 28%;
        }

        .col-status {
            width: 9%;
        }

        .col-dibaca {
            width: 8%;
        }

        .col-created {
            width: 15%;
        }

        .col-updated {
            width: 15%;
        }
    </style>
</head>

<body>

    {{-- =========================
     HEADER
========================= --}}
    <div class="header">
        <table class="header-table">
            <tr>
                <td>
                    <div class="header-title">
                        Laporan Data Berita
                    </div>

                    <div class="header-subtitle">
                        Daftar berita yang tersedia pada sistem
                    </div>
                </td>

                <td class="generated-at">
                    Dicetak pada:<br>
                    <strong>
                        {{ now()->format('d-m-Y H:i') }}
                    </strong>
                </td>
            </tr>
        </table>
    </div>


    {{-- =========================
     RINGKASAN
========================= --}}
    <table class="summary">
        <tr>
            <td>
                <span class="summary-label">
                    Total Data
                </span>

                <span class="summary-value">
                    {{ $berita->count() }}
                </span>
            </td>

            <td>
                <span class="summary-label">
                    Berita Aktif
                </span>

                <span class="summary-value">
                    {{ $berita->where('status_id', 1)->count() }}
                </span>
            </td>

            <td>
                <span class="summary-label">
                    Berita Nonaktif
                </span>

                <span class="summary-value">
                    {{ $berita->where('status_id', 0)->count() }}
                </span>
            </td>

            <td>
                <span class="summary-label">
                    Total Dibaca
                </span>

                <span class="summary-value">
                    {{ number_format($berita->sum('dibaca'), 0, ',', '.') }}
                </span>
            </td>
        </tr>
    </table>


    {{-- =========================
     INFORMASI FILTER
========================= --}}
    @if (!empty($search) || !empty($tanggalMulai) || !empty($tanggalAkhir))
        <div class="filter-box">

            <div class="filter-title">
                Filter Data
            </div>

            <table class="filter-table">

                @if (!empty($search))
                    <tr>
                        <td class="filter-label">
                            Kata Kunci
                        </td>

                        <td class="filter-value">
                            : {{ $search }}
                        </td>
                    </tr>
                @endif


                @if (!empty($tanggalMulai))
                    <tr>
                        <td class="filter-label">
                            Tanggal Mulai
                        </td>

                        <td class="filter-value">
                            :
                            {{ \Carbon\Carbon::parse($tanggalMulai)->format('d-m-Y') }}
                        </td>
                    </tr>
                @endif


                @if (!empty($tanggalAkhir))
                    <tr>
                        <td class="filter-label">
                            Tanggal Akhir
                        </td>

                        <td class="filter-value">
                            :
                            {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d-m-Y') }}
                        </td>
                    </tr>
                @endif

            </table>
        </div>
    @endif


    {{-- =========================
     TABEL BERITA
========================= --}}
    <table class="data-table">

        <thead>
            <tr>
                <th class="col-no">
                    No
                </th>

                <th class="col-tanggal">
                    Tanggal
                </th>

                <th class="col-judul">
                    Judul Berita
                </th>

                <th class="col-status">
                    Status
                </th>

                <th class="col-dibaca">
                    Dibaca
                </th>

                <th class="col-created">
                    Dibuat Oleh
                </th>

                <th class="col-updated">
                    Diperbarui Oleh
                </th>
            </tr>
        </thead>

        <tbody>

            @forelse($berita as $index => $item)
                <tr>

                    {{-- NO --}}
                    <td class="text-center">
                        {{ $index + 1 }}
                    </td>


                    {{-- TANGGAL --}}
                    <td class="text-center">
                        @if (!empty($item->tgl))
                            {{ \Carbon\Carbon::parse($item->tgl)->format('d-m-Y') }}
                        @else
                            -
                        @endif
                    </td>


                    {{-- JUDUL --}}
                    <td class="text-left">
                        {{ $item->judul ?? '-' }}
                    </td>


                    {{-- STATUS --}}
                    <td class="text-center">

                        @if ((int) $item->status_id === 1)
                            <span class="status status-active">
                                Aktif
                            </span>
                        @else
                            <span class="status status-inactive">
                                Nonaktif
                            </span>
                        @endif

                    </td>


                    {{-- DIBACA --}}
                    <td class="text-center">

                        {{ number_format((int) ($item->dibaca ?? 0), 0, ',', '.') }}

                    </td>


                    {{-- CREATED BY --}}
                    <td class="text-center">
                        {{ $item->created_by ?? '-' }}
                    </td>


                    {{-- UPDATED BY --}}
                    <td class="text-center">
                        {{ $item->updated_by ?? '-' }}
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="7" class="no-data">
                        Data berita tidak ditemukan.
                    </td>
                </tr>
            @endforelse

        </tbody>

    </table>


    {{-- =========================
     FOOTER
========================= --}}
    <div class="footer">

        <table class="footer-table">
            <tr>

                <td>
                    Laporan Data Berita
                </td>

                <td>
                    Total {{ $berita->count() }} data
                </td>

            </tr>
        </table>

    </div>

</body>

</html>
