@extends('layouts.app')

@section('title', 'Profil')

@section('header', 'Profil')

@section('breadcrumbs')
<li class="breadcrumb-item active">Profil</li>
@endsection

@section('content')
<!-- Page Header -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-1">Profil utilizator</h4>
                    <p class="text-muted mb-0">Vizualizează și editează informațiile profilului tău</p>
                </div>
                <div>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Editează profilul
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Profile Content -->
<div class="row">
    <!-- Profile Sidebar -->
    <div class="col-lg-4 mb-4 mb-lg-0">
        <!-- User Card -->
        <div class="card mb-4">
            <div class="card-body text-center">
                <div class="position-relative d-inline-block mb-4">
                    <img src="https://via.placeholder.com/150" class="rounded-circle img-thumbnail shadow" alt="Profile Photo" width="150">
                    <button class="btn btn-sm btn-icon btn-primary position-absolute bottom-0 end-0 rounded-circle shadow">
                        <i class="fas fa-camera"></i>
                    </button>
                </div>
                <h4 class="fw-bold mb-1">Ionuț Ceahlău</h4>
                <p class="text-muted mb-3">Administrator</p>
                
                <div class="d-flex justify-content-center mb-3">
                    <a href="#" class="btn btn-sm btn-icon btn-outline-primary rounded-circle mx-1">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-icon btn-outline-info rounded-circle mx-1">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-icon btn-outline-danger rounded-circle mx-1">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-icon btn-outline-primary rounded-circle mx-1">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
                
                <div class="d-grid">
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-envelope me-2"></i>Trimite mesaj
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Contact Info -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Informații de contact</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <p class="small text-muted mb-0">Email</p>
                        <p class="mb-0">ionut@example.com</p>
                    </div>
                </div>
                
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar-sm bg-success bg-opacity-10 text-success rounded-circle">
                            <i class="fas fa-phone"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <p class="small text-muted mb-0">Telefon</p>
                        <p class="mb-0">+40 722 123 456</p>
                    </div>
                </div>
                
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar-sm bg-info bg-opacity-10 text-info rounded-circle">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <p class="small text-muted mb-0">Adresă</p>
                        <p class="mb-0">Str. Victoriei nr. 123, București, România</p>
                    </div>
                </div>
                
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar-sm bg-warning bg-opacity-10 text-warning rounded-circle">
                            <i class="fas fa-globe"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <p class="small text-muted mb-0">Website</p>
                        <p class="mb-0">www.example.com</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Skills -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Abilități</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span>HTML & CSS</span>
                        <span>90%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 90%;" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span>JavaScript</span>
                        <span>85%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 85%;" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span>PHP & Laravel</span>
                        <span>95%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 95%;" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span>UI/UX Design</span>
                        <span>70%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span>Database Management</span>
                        <span>80%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Profile Content -->
    <div class="col-lg-8">
        <!-- About -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Despre mine</h5>
            </div>
            <div class="card-body">
                <p>Sunt un dezvoltator web pasionat cu peste 5 ani de experiență în dezvoltarea aplicațiilor web folosind cele mai recente tehnologii. Specializat în dezvoltarea cu PHP și Laravel, sunt dedicat creării de aplicații performante și ușor de utilizat.</p>
                
                <p>Pe lângă programare, sunt pasionat de design, UX și de crearea unor experiențe digitale care nu doar funcționează bine, ci arată și excelent. Cred în importanța codului curat, a documentației adecvate și a lucrului în echipă pentru a crea produse de succes.</p>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="fw-bold">Nume complet</h6>
                            <p class="text-muted">Ionuț Ceahlău</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="fw-bold">Email</h6>
                            <p class="text-muted">ionut@example.com</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="fw-bold">Data nașterii</h6>
                            <p class="text-muted">15 Septembrie 1990</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <h6 class="fw-bold">Locație</h6>
                            <p class="text-muted">București, România</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Experience -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Experiență</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item pb-4">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="timeline-icon bg-primary">
                                    <i class="fas fa-briefcase text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="fw-bold mb-0">Senior Web Developer</h6>
                                    <span class="badge bg-primary">Prezent</span>
                                </div>
                                <p class="text-muted mb-2">Tech Solutions SRL • 2021 - Prezent</p>
                                <p>Dezvoltarea și menținerea aplicațiilor web bazate pe Laravel pentru clienți din diverse industrii. Coordonarea unei echipe de 3 dezvoltatori și implementarea celor mai bune practici de dezvoltare.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="timeline-item pb-4">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="timeline-icon bg-info">
                                    <i class="fas fa-briefcase text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="fw-bold mb-0">Web Developer</h6>
                                    <span class="badge bg-info">3 ani</span>
                                </div>
                                <p class="text-muted mb-2">Digital Agency • 2018 - 2021</p>
                                <p>Dezvoltarea de site-uri web și aplicații personalizate folosind Laravel, Vue.js și Bootstrap. Colaborarea cu designeri și specialiști în marketing pentru a crea soluții complete pentru clienți.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="timeline-icon bg-success">
                                    <i class="fas fa-briefcase text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="fw-bold mb-0">Junior Developer</h6>
                                    <span class="badge bg-success">2 ani</span>
                                </div>
                                <p class="text-muted mb-2">WebStudio • 2016 - 2018</p>
                                <p>Începerea carierei în dezvoltarea web cu focus pe partea de front-end. Lucrul cu HTML, CSS, JavaScript și PHP pentru a crea site-uri web responsive și atractive.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Education -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Educație</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item pb-4">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="timeline-icon bg-primary">
                                    <i class="fas fa-graduation-cap text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="fw-bold mb-0">Master în Informatică</h6>
                                    <span class="badge bg-primary">2014 - 2016</span>
                                </div>
                                <p class="text-muted mb-2">Universitatea din București</p>
                                <p>Specializare în Ingineria Sistemelor Software cu focus pe dezvoltarea aplicațiilor web și mobile.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="timeline-icon bg-info">
                                    <i class="fas fa-graduation-cap text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="fw-bold mb-0">Licență în Informatică</h6>
                                    <span class="badge bg-info">2010 - 2014</span>
                                </div>
                                <p class="text-muted mb-2">Universitatea din București</p>
                                <p>Studii de bază în programare, algoritmi, baze de date și dezvoltare software, cu o medie generală de 9.5.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activities -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Activitate recentă</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <div class="list-group-item p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle">
                                    <i class="fas fa-code"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">A adăugat un produs nou</h6>
                                    <small class="text-muted">Acum 2 ore</small>
                                </div>
                                <p class="text-muted mb-0">A adăugat "iPhone 13 Pro" în catalog.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="list-group-item p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm bg-success bg-opacity-10 text-success rounded-circle">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">A adăugat un utilizator nou</h6>
                                    <small class="text-muted">Ieri</small>
                                </div>
                                <p class="text-muted mb-0">A adăugat utilizatorul "Maria Ionescu" în sistem.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="list-group-item p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm bg-info bg-opacity-10 text-info rounded-circle">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">A generat un raport</h6>
                                    <small class="text-muted">2 zile în urmă</small>
                                </div>
                                <p class="text-muted mb-0">A generat raportul de vânzări pentru luna aprilie.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="list-group-item p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm bg-warning bg-opacity-10 text-warning rounded-circle">
                                    <i class="fas fa-cog"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">A actualizat setările</h6>
                                    <small class="text-muted">5 zile în urmă</small>
                                </div>
                                <p class="text-muted mb-0">A actualizat setările de notificări și securitate.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .avatar-sm {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }
    
    .timeline-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }
    
    .timeline-item {
        position: relative;
    }
    
    .timeline-item:not(:last-child)::after {
        content: '';
        position: absolute;
        left: 20px;
        top: 40px;
        bottom: 0;
        width: 1px;
        background-color: #e0e0e0;
    }
</style>
@endpush 