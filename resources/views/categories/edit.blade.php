<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaStore - Kategori Düzenle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0 fw-bold">Kategoriyi Düzenle</h4>
                    </div>
                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('categories.update', $category->id) }}" method="POST">
                            @csrf
                            @method('PUT') <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Kategori Adı</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold">Açıklama (Opsiyonel)</label>
                                <textarea name="description" id="description" rows="3" class="form-control">{{ old('description', $category->description) }}</textarea>
                            </div>

                            <div class="mt-4 d-flex justify-content-between">
                                <a href="{{ route('categories.index') }}" class="btn btn-secondary">İptal Et / Geri Dön</a>
                                <button type="submit" class="btn btn-warning fw-bold text-dark">Değişiklikleri Kaydet</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>