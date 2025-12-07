@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-3xl font-bold text-gray-900">Riwayat Pembayaran</h1>
                <p class="mt-2 text-sm text-gray-600">Permohonan: {{ $permohonan->judul }}</p>
            </div>

            <!-- Content -->
            <div class="px-6 py-8">
                @if($pembayarans->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100 border-b border-gray-300">
                                    <th class="px-4 py-3 text-left text-sm font-semibold">Tanggal</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold">Nominal</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold">Metode</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold">Status</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pembayarans as $pembayaran)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm">{{ $pembayaran->created_at->format('d M Y H:i') }}</td>
                                        <td class="px-4 py-3 text-sm font-semibold">Rp {{ number_format($pembayaran->amount, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-sm">{{ $pembayaran->payment_method_name ?? $pembayaran->payment_method ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm">
                                            @if($pembayaran->isSuccessful())
                                                <span class="px-3 py-1 bg-green-200 text-green-800 rounded-full text-xs font-semibold">Berhasil</span>
                                            @elseif($pembayaran->isFailed())
                                                <span class="px-3 py-1 bg-red-200 text-red-800 rounded-full text-xs font-semibold">Gagal</span>
                                            @else
                                                <span class="px-3 py-1 bg-yellow-200 text-yellow-800 rounded-full text-xs font-semibold">Menunggu</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            @if($pembayaran->isSuccessful())
                                                <a href="{{ route('payment.invoice', $pembayaran) }}" class="text-blue-600 hover:text-blue-700 underline">
                                                    Invoice
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-600">Belum ada riwayat pembayaran</p>
                    </div>
                @endif

                <div class="mt-6">
                    <a href="{{ route('payment.show', $permohonan) }}" class="text-blue-600 hover:text-blue-700 underline">
                        ← Kembali ke pembayaran
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
