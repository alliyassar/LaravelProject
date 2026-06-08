<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaStore - Ürün Yönetimi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">NovaStore - Ürün Yönetim Paneli</h4>
                <a href="{{ route('products.create') }}" class="btn btn-light btn-sm fw-bold">+ Yeni Ürün Ekle</a>
            </div>
            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Ürün Adı</th>
                                <th>Açıklama</th>
                                <th>Fiyat</th>
                                <th>Stok</th>
                                <th class="text-center">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td class="fw-bold">{{ $product->name }}</td>
                                    <td>{{ $product->description ?? 'Açıklama Yok' }}</td>
                                    <td class="text-success fw-bold">{{ number_format($product->price, 2) }} TL</td>
                                    <td>
                                        <span class="badge {{ $product->stock > 10 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $product->stock }} Adet
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Bu ürünü silmek istediğinize emin misiniz?')">
                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Düzenle</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Sil</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Henüz hiç ürün eklenmemiş.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</body>
</html>