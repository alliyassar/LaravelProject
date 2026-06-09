@extends('welcome')

@section('title') E-SHOP - Yeni Ürün Ekleme Paneli @endsection

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 rounded-0 shadow-sm">
                <div class="card-header text-white fw-bold text-uppercase rounded-0" style="background-color: #15161D; border-bottom: 3px solid #FF6600;">
                    <i class="fa-solid fa-plus-square me-2"></i> Envantere Yeni Ürün Ekleme
                </div>
                
                <div class="card-body p-4 bg-white">
                    @if(session('success'))
                        <div class="alert alert-success rounded-0 fw-bold small">
                            <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form action="/admin/products/store" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-uppercase small text-secondary">Ürün Adı (Product Name)</label>
                            <input type="text" name="name" class="form-control rounded-0" placeholder="Örn: Dell Tower Plus Desktop" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-uppercase small text-secondary">Fiyat ($ - Price)</label>
                                <input type="number" step="0.01" name="price" class="form-control rounded-0" placeholder="0.00" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-uppercase small text-secondary">Kategori Grubu (Category)</label>
                                <select name="category" class="form-select rounded-0" required>
                                    <option value="">Kategori Seçiniz</option>
                                    <option value="1">Laptops / Computers</option>
                                    <option value="2">Smartphones</option>
                                    <option value="3">Cameras / Accessories</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-uppercase small text-secondary">Ürün Açıklaması (Description)</label>
                            <textarea name="description" class="form-control rounded-0" rows="5" placeholder="Ürün teknik özelliklerini ve detaylarını buraya giriniz..." required></textarea>
                        </div>

                        <div class="d-flex gap-2 justify-content-end border-top pt-3">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-0 text-uppercase small">Vitrini Görüntüle</a>
                            <button type="submit" class="btn text-white fw-bold rounded-0 px-4 text-uppercase small" style="background-color: #FF6600; border: none;">
                                <i class="fa-solid fa-save me-2"></i> Ürünü Kaydet
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection