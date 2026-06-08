<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaStore - Müşteri Yönetimi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-navy text-white d-flex justify-content-between align-items-center" style="background-color: #1d2d44;">
                <h4 class="mb-0">NovaStore - Müşteri Yönetim Paneli</h4>
                <a href="{{ route('customers.create') }}" class="btn btn-light btn-sm fw-bold">+ Yeni Müşteri Ekle</a>
            </div>
            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th>ID</th>
                                <th>Müşteri Adı Soyadı</th>
                                <th>E-posta Adresi</th>
                                <th>Telefon</th>
                                <th class="text-center">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $customer)
                                <tr>
                                    <td>{{ $customer->id }}</td>
                                    <td class="fw-bold text-dark">{{ $customer->name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->phone ?? 'Telefon Yok' }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Bu müşteriyi silmek istediğinize emin misiniz?')">
                                            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">Düzenle</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Sil</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Henüz hiç müşteri eklenmemiş.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 d-flex gap-2">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">← Ürün Paneline Geç</a>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary btn-sm">Kategori Paneline Geç →</a>
                </div>

            </div>
        </div>
    </div>

</body>
</html>