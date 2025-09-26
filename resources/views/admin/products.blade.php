@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Quản lý sản phẩm</h2>

        <!-- Form thêm sản phẩm -->
        <div class="bg-white shadow rounded-2xl p-6 mb-8">
            <form action="{{ route('admin.products.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="text" name="name" placeholder="Tên sản phẩm"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <input type="number" name="price" placeholder="Giá"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <input type="text" name="category" placeholder="Danh mục"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <input type="text" name="colors" placeholder="Màu sắc"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <input type="text" name="tag" placeholder="Tag"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <input type="text" name="image_main" placeholder="Ảnh chính (URL)"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <input type="text" name="image_hover" placeholder="Ảnh hover (URL)"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
                    Thêm sản phẩm
                </button>
            </form>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="overflow-hidden bg-white shadow rounded-2xl">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">Tên</th>
                        <th class="px-6 py-3">Giá</th>
                        <th class="px-6 py-3">Danh mục</th>
                        <th class="px-6 py-3">Màu sắc</th>
                        <th class="px-6 py-3">Tag</th>
                        <th class="px-6 py-3">Ảnh chính</th>
                        <th class="px-6 py-3">Ảnh hover</th>
                        <th class="px-6 py-3 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $sp)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $sp->name }}</td>
                            <td class="px-6 py-4">{{ number_format($sp->price) }}</td>
                            <td class="px-6 py-4">{{ $sp->category }}</td>
                            <td class="px-6 py-4">{{ $sp->colors }}</td>
                            <td class="px-6 py-4">{{ $sp->tag }}</td>
                            <td class="px-6 py-4">
                                <img src="{{ asset($sp->image_main) }}" alt="Ảnh chính" class="w-16 h-16 object-cover rounded">
                            </td>
                            <td class="px-6 py-4">
                                <img src="{{ asset($sp->image_hover) }}" alt="Ảnh hover" class="w-16 h-16 object-cover rounded">
                            </td>


                            <td class="px-6 py-4 text-center space-y-2">
                                <!-- Nút mở modal -->
                                <button onclick="openEditModal({{ $sp->id }})"
                                    class="w-full px-3 py-1 bg-yellow-500 text-white text-xs rounded-lg hover:bg-yellow-600 transition">
                                    Cập nhật
                                </button>

                                <!-- Modal cập nhật -->
                                <div id="editModal-{{ $sp->id }}"
                                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                                    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
                                        <!-- Nút đóng -->
                                        <button onclick="closeEditModal({{ $sp->id }})"
                                            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">✖</button>

                                        <h2 class="text-lg font-bold mb-4">Chỉnh sửa sản phẩm</h2>

                                        <form action="{{ route('admin.products.update', $sp->id) }}" method="POST"
                                            class="space-y-3">
                                            @csrf
                                            <input type="text" name="name" value="{{ $sp->name }}" placeholder="Tên sản phẩm"
                                                class="w-full px-3 py-2 border rounded-md">
                                            <input type="number" name="price" value="{{ $sp->price }}" placeholder="Giá"
                                                class="w-full px-3 py-2 border rounded-md">
                                            <input type="text" name="category" value="{{ $sp->category }}"
                                                placeholder="Danh mục" class="w-full px-3 py-2 border rounded-md">
                                            <input type="text" name="colors" value="{{ $sp->colors }}" placeholder="Màu sắc"
                                                class="w-full px-3 py-2 border rounded-md">
                                            <input type="text" name="tag" value="{{ $sp->tag }}" placeholder="Tag"
                                                class="w-full px-3 py-2 border rounded-md">
                                            <input type="text" name="image_main" value="{{ $sp->image_main }}"
                                                placeholder="Ảnh chính" class="w-full px-3 py-2 border rounded-md">
                                            <input type="text" name="image_hover" value="{{ $sp->image_hover }}"
                                                placeholder="Ảnh hover" class="w-full px-3 py-2 border rounded-md">

                                            <button class="w-full py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                                                Cập nhật
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Xóa -->
                                <form action="{{ route('admin.products.delete', $sp->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="w-full px-3 py-1 bg-red-600 text-white text-xs rounded-lg hover:bg-red-700 transition">
                                        Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-400 text-base">
                                Không có sản phẩm nào
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

    <script>
        function openEditModal(id) {
            document.getElementById('editModal-' + id).classList.remove('hidden');
        }
        function closeEditModal(id) {
            document.getElementById('editModal-' + id).classList.add('hidden');
        }
    </script>
@endsection