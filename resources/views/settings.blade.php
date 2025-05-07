@extends('layouts.app')

@section('title', 'Setări')

@section('header', 'Setări')

@section('breadcrumbs')
<li class="breadcrumb-item active">Setări</li>
@endsection

@section('content')
<!-- Page Header -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-1">Setări platformă</h4>
                    <p class="text-muted mb-0">Configurează și personalizează aplicația</p>
                </div>
                <div>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Salvează modificările
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Settings Content -->
<div class="row">
    <div class="col-lg-3 mb-4 mb-lg-0">
        <div class="card">
            <div class="card-body p-0">
                <div class="list-group list-group-flush rounded-0">
                    <a href="#general" class="list-group-item list-group-item-action active d-flex align-items-center">
                        <i class="fas fa-cog me-3"></i>
                        <span>General</span>
                    </a>
                    <a href="#profile" class="list-group-item list-group-item-action d-flex align-items-center">
                        <i class="fas fa-user me-3"></i>
                        <span>Profil</span>
                    </a>
                    <a href="#security" class="list-group-item list-group-item-action d-flex align-items-center">
                        <i class="fas fa-shield-alt me-3"></i>
                        <span>Securitate</span>
                    </a>
                    <a href="#notifications" class="list-group-item list-group-item-action d-flex align-items-center">
                        <i class="fas fa-bell me-3"></i>
                        <span>Notificări</span>
                    </a>
                    <a href="#billing" class="list-group-item list-group-item-action d-flex align-items-center">
                        <i class="fas fa-credit-card me-3"></i>
                        <span>Facturare</span>
                    </a>
                    <a href="#appearance" class="list-group-item list-group-item-action d-flex align-items-center">
                        <i class="fas fa-palette me-3"></i>
                        <span>Aspect</span>
                    </a>
                    <a href="#integrations" class="list-group-item list-group-item-action d-flex align-items-center">
                        <i class="fas fa-plug me-3"></i>
                        <span>Integrări</span>
                    </a>
                    <a href="#advanced" class="list-group-item list-group-item-action d-flex align-items-center">
                        <i class="fas fa-sliders-h me-3"></i>
                        <span>Avansat</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-9">
        <!-- General Settings -->
        <div class="card mb-4" id="general">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Setări generale</h5>
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label for="companyName" class="form-label">Numele companiei</label>
                        <input type="text" class="form-control" id="companyName" value="Compania Mea SRL">
                    </div>
                    
                    <div class="mb-3">
                        <label for="websiteUrl" class="form-label">Adresa website</label>
                        <input type="url" class="form-control" id="websiteUrl" value="https://example.com">
                    </div>
                    
                    <div class="mb-3">
                        <label for="contactEmail" class="form-label">Email de contact</label>
                        <input type="email" class="form-control" id="contactEmail" value="contact@example.com">
                    </div>
                    
                    <div class="mb-3">
                        <label for="language" class="form-label">Limbă</label>
                        <select class="form-select" id="language">
                            <option value="ro" selected>Română</option>
                            <option value="en">Engleză</option>
                            <option value="fr">Franceză</option>
                            <option value="de">Germană</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="timezone" class="form-label">Fus orar</label>
                        <select class="form-select" id="timezone">
                            <option value="Europe/Bucharest" selected>Europe/Bucharest (GMT+3)</option>
                            <option value="Europe/London">Europe/London (GMT+1)</option>
                            <option value="America/New_York">America/New_York (GMT-4)</option>
                            <option value="Asia/Tokyo">Asia/Tokyo (GMT+9)</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="dateFormat" class="form-label">Format dată</label>
                        <select class="form-select" id="dateFormat">
                            <option value="DD/MM/YYYY" selected>DD/MM/YYYY</option>
                            <option value="MM/DD/YYYY">MM/DD/YYYY</option>
                            <option value="YYYY-MM-DD">YYYY-MM-DD</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="currency" class="form-label">Monedă</label>
                        <select class="form-select" id="currency">
                            <option value="RON" selected>RON (Romanian Leu)</option>
                            <option value="EUR">EUR (Euro)</option>
                            <option value="USD">USD (US Dollar)</option>
                            <option value="GBP">GBP (British Pound)</option>
                        </select>
                    </div>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="enableAnalytics" checked>
                        <label class="form-check-label" for="enableAnalytics">Activează Google Analytics</label>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Profile Settings -->
        <div class="card mb-4" id="profile">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Setări profil</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <img src="https://via.placeholder.com/100" class="rounded-circle me-4" alt="Profile">
                    <div>
                        <h5 class="mb-1">Ionuț Ceahlău</h5>
                        <p class="text-muted mb-2">Administrator</p>
                        <button class="btn btn-sm btn-primary">Schimbă fotografia</button>
                        <button class="btn btn-sm btn-outline-danger ms-2">Șterge</button>
                    </div>
                </div>
                
                <form>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="firstName" class="form-label">Prenume</label>
                            <input type="text" class="form-control" id="firstName" value="Ionuț">
                        </div>
                        <div class="col-md-6">
                            <label for="lastName" class="form-label">Nume</label>
                            <input type="text" class="form-control" id="lastName" value="Ceahlău">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" value="ionut@example.com">
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Telefon</label>
                        <input type="tel" class="form-control" id="phone" value="+40 722 123 456">
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Adresă</label>
                        <textarea class="form-control" id="address" rows="3">Str. Victoriei nr. 123, București</textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="bio" class="form-label">Descriere</label>
                        <textarea class="form-control" id="bio" rows="3">Administrator și dezvoltator al platformei cu peste 5 ani de experiență în dezvoltarea aplicațiilor web.</textarea>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Security Settings -->
        <div class="card" id="security">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Securitate</h5>
            </div>
            <div class="card-body">
                <h6 class="mb-3">Schimbă parola</h6>
                <form>
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Parola curentă</label>
                        <input type="password" class="form-control" id="currentPassword">
                    </div>
                    
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">Parola nouă</label>
                        <input type="password" class="form-control" id="newPassword">
                    </div>
                    
                    <div class="mb-4">
                        <label for="confirmPassword" class="form-label">Confirmă parola nouă</label>
                        <input type="password" class="form-control" id="confirmPassword">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Actualizează parola</button>
                </form>
                
                <hr class="my-4">
                
                <h6 class="mb-3">Autentificare în doi pași</h6>
                <p class="text-muted mb-3">Adaugă un nivel suplimentar de securitate pentru contul tău. La autentificare, vei fi solicitat să introduci și un cod primit pe telefonul mobil.</p>
                
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="enableTwoFactor">
                    <label class="form-check-label" for="enableTwoFactor">Activează autentificarea în doi pași</label>
                </div>
                
                <hr class="my-4">
                
                <h6 class="mb-3">Sesiuni active</h6>
                <p class="text-muted mb-3">Acestea sunt dispozitivele care sunt conectate în prezent la contul tău. Poți deconecta orice sesiune pe care nu o recunoști.</p>
                
                <div class="list-group mb-4">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">MacBook Pro - Chrome</h6>
                            <small class="text-muted">București, Romania - Acum</small>
                        </div>
                        <span class="badge bg-success">Activ</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">iPhone 13 - Safari</h6>
                            <small class="text-muted">București, Romania - Acum 2 ore</small>
                        </div>
                        <button class="btn btn-sm btn-outline-danger">Deconectare</button>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Windows PC - Firefox</h6>
                            <small class="text-muted">Brașov, Romania - Acum 2 zile</small>
                        </div>
                        <button class="btn btn-sm btn-outline-danger">Deconectare</button>
                    </div>
                </div>
                
                <button class="btn btn-danger">Deconectează toate sesiunile</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Scroll to settings section when clicking menu items
    document.querySelectorAll('.list-group-item-action').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all items
            document.querySelectorAll('.list-group-item-action').forEach(i => {
                i.classList.remove('active');
            });
            
            // Add active class to clicked item
            this.classList.add('active');
            
            // Get target element
            const target = document.querySelector(this.getAttribute('href'));
            
            // Scroll to target
            if (target) {
                window.scrollTo({
                    top: target.offsetTop - 20,
                    behavior: 'smooth'
                });
            }
        });
    });
</script>
@endpush 