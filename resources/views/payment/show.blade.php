@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-3xl font-bold text-gray-900">Pembayaran Permohonan</h1>
                <p class="mt-2 text-sm text-gray-600">Permohonan: {{ $permohonan->judul }}</p>
            </div>

            <!-- Content -->
            <div class="px-6 py-8">
                @if($pembayaran->isSuccessful())
                    <!-- Status Pembayaran Berhasil -->
                    <div class="mb-6 p-4 bg-green-100 border border-green-400 rounded">
                        <p class="text-green-700 font-semibold">✓ Pembayaran berhasil!</p>
                        <p class="text-green-600 text-sm mt-2">Terima kasih telah melakukan pembayaran. Silahkan tunggu verifikasi sampel dari petugas.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-sm text-gray-600">Status Pembayaran</p>
                            <p class="text-lg font-semibold text-green-600">Berhasil</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Nominal</p>
                            <p class="text-lg font-semibold">Rp {{ number_format($pembayaran->amount, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Metode Pembayaran</p>
                            <p class="text-lg font-semibold">{{ $pembayaran->payment_method_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Pembayaran</p>
                            <p class="text-lg font-semibold">{{ $pembayaran->paid_at?->format('d M Y H:i') ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('payment.invoice', $pembayaran) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Download Invoice
                        </a>
                        <a href="{{ route('filament.admin.pages.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                            Kembali ke Dashboard
                        </a>
                    </div>
                @elseif($pembayaran->isFailed())
                    <!-- Status Pembayaran Gagal -->
                    <div class="mb-6 p-4 bg-red-100 border border-red-400 rounded">
                        <p class="text-red-700 font-semibold">✗ Pembayaran gagal</p>
                        <p class="text-red-600 text-sm mt-2">Pembayaran Anda tidak berhasil. Silahkan coba lagi dengan metode pembayaran yang berbeda.</p>
                    </div>

                    <h2 class="text-xl font-semibold mb-4 mt-8">Pilih Metode Pembayaran</h2>

                    <form method="POST" action="{{ route('payment.process', $permohonan) }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            @forelse($paymentMethods as $method)
                                <label class="flex items-center p-4 border border-gray-300 rounded cursor-pointer hover:bg-blue-50">
                                    <input type="radio" name="payment_method" value="{{ $method->payment_method }}" required class="mr-3">
                                    <div class="flex-1">
                                        <p class="font-semibold">{{ $method->payment_name }}</p>
                                        @if($method->total_fee > 0)
                                            <p class="text-sm text-gray-600">Biaya: Rp {{ number_format($method->total_fee, 0, ',', '.') }}</p>
                                        @else
                                            <p class="text-sm text-gray-600">Tanpa biaya tambahan</p>
                                        @endif
                                    </div>
                                    @if($method->payment_image)
                                        <img src="{{ $method->payment_image }}" alt="{{ $method->payment_name }}" class="w-12 h-12">
                                    @endif
                                </label>
                            @empty
                                <p class="text-gray-600">Metode pembayaran tidak tersedia</p>
                            @endforelse
                        </div>

                        <div class="bg-gray-50 p-4 rounded mb-6">
                            <p class="text-sm text-gray-600">Total yang harus dibayar:</p>
                            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($pembayaran->amount, 0, ',', '.') }}</p>
                        </div>

                        <button type="submit" class="w-full px-4 py-3 bg-blue-600 text-white rounded font-semibold hover:bg-blue-700">
                            Lanjutkan ke Pembayaran
                        </button>
                    </form>
                @else
                    <!-- Status Pembayaran Menunggu -->
                    <div class="mb-6 p-4 bg-yellow-100 border border-yellow-400 rounded">
                        <p class="text-yellow-700 font-semibold">⏳ Menunggu Pembayaran</p>
                        <p class="text-yellow-600 text-sm mt-2">Silahkan lakukan pembayaran dengan metode yang Anda pilih di bawah ini.</p>
                    </div>

                    @if($pembayaran->payment_url)
                        <div class="mb-6 p-4 bg-blue-100 border border-blue-400 rounded">
                            <p class="text-blue-700 font-semibold mb-2">Instruksi Pembayaran</p>
                            <p class="text-blue-600 text-sm mb-3">
                                Anda telah memilih metode pembayaran: <strong>{{ $pembayaran->payment_method_name }}</strong>
                            </p>
                            @if($pembayaran->va_number)
                                <p class="text-blue-600 text-sm">
                                    Nomor Virtual Account: <strong>{{ $pembayaran->va_number }}</strong>
                                </p>
                            @endif
                            <a href="{{ $pembayaran->payment_url }}" class="mt-3 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Lanjutkan Pembayaran
                            </a>
                        </div>
                    @endif

                    <h2 class="text-xl font-semibold mb-4 mt-8">Pilih Metode Pembayaran</h2>

                    <form method="POST" action="{{ route('payment.process', $permohonan) }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            @forelse($paymentMethods as $method)
                                <label class="flex items-center p-4 border border-gray-300 rounded cursor-pointer hover:bg-blue-50">
                                    <input type="radio" name="payment_method" value="{{ $method->payment_method }}" required class="mr-3">
                                    <div class="flex-1">
                                        <p class="font-semibold">{{ $method->payment_name }}</p>
                                        @if($method->total_fee > 0)
                                            <p class="text-sm text-gray-600">Biaya: Rp {{ number_format($method->total_fee, 0, ',', '.') }}</p>
                                        @else
                                            <p class="text-sm text-gray-600">Tanpa biaya tambahan</p>
                                        @endif
                                    </div>
                                    @if($method->payment_image)
                                        <img src="{{ $method->payment_image }}" alt="{{ $method->payment_name }}" class="w-12 h-12">
                                    @endif
                                </label>
                            @empty
                                <p class="text-gray-600">Metode pembayaran tidak tersedia</p>
                            @endforelse
                        </div>

                        <div class="bg-gray-50 p-4 rounded mb-6">
                            <p class="text-sm text-gray-600">Total yang harus dibayar:</p>
                            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($pembayaran->amount, 0, ',', '.') }}</p>
                        </div>

                        <button type="submit" class="w-full px-4 py-3 bg-blue-600 text-white rounded font-semibold hover:bg-blue-700">
                            Lanjutkan ke Pembayaran
                        </button>
                    </form>
                @endif

                <!-- Riwayat Pembayaran -->
                <div class="mt-12 pt-8 border-t border-gray-200">
                    <h2 class="text-xl font-semibold mb-4">Riwayat Pembayaran</h2>
                    <a href="{{ route('payment.history', $permohonan) }}" class="text-blue-600 hover:text-blue-700 underline">
                        Lihat semua riwayat pembayaran →
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
