<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaStore - Müşteri Düzenle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0 fw-bold">Müşteri Bilgilerini Düzenle</h4>
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

                        <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Müşteri Adı Soyadı</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $customer->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">E-posta Adresi</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $customer->email) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label fw-bold">Telefon Numarası (Opsiyonel)</label>
                                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $customer->phone) }}">
                            </div>

                            <div class="mt-4 d-flex justify-content-between">
                                <a href="{{ route('customers.index') }}" class="btn btn-secondary">İptal Et / Geri Dön</a>
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