@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            Danh sách đơn hàng
        </h2>
    </div>

    <div class="overflow-hidden bg-white shadow-md rounded-2xl">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-center">Mã đơn</th>
                    <th class="px-6 py-3">Khách hàng</th>
                    <th class="px-6 py-3">Ngày tạo</th>
                    <th class="px-6 py-3">Sản phẩm</th>
                    <th class="px-6 py-3 text-center">Tổng SL</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $don)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-center font-semibold text-gray-800">
                            #{{ $don->id }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $don->user->ho_ten ?? '—' }}
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ \Carbon\Carbon::parse($don->ngay_tao)->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <ul class="space-y-1">
                                @foreach($don->chiTietDonHang as $ct)
                                    <li class="flex items-center justify-between">
                                        <span class="font-medium text-gray-700">{{ $ct->product->name }}</span>
                                        <span class="text-gray-500">× {{ $ct->so_luong }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-6 py-4 text-center font-bold text-gray-800">
                            {{ $don->chiTietDonHang->sum('so_luong') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400 text-base">
                            Không có đơn hàng nào
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.dashboard') }}"
           class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-700 rounded-lg shadow hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition">
            ← Quay lại
        </a>
    </div>
</div>
@endsection
