import './bootstrap';

// Import Bootstrap JS și componente
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

// Import FontAwesome
import '@fortawesome/fontawesome-free/js/all';

// Importă stilurile în aplicație
import '../css/app.css';

// Event listener când documentul este încărcat
document.addEventListener('DOMContentLoaded', function() {
    // Toggle pentru sidebar
    initSidebar();
    
    // Activează toate tooltip-urile și popover-urile
    initTooltipsAndPopovers();
    
    // Funcționalitate pentru dropdown-uri
    initDropdowns();
    
    // Simulare date pentru grafice (în aplicația reală, ar veni din backend)
    mockChartData();
    
    // Adaugă ascultători de evenimente pentru card-uri
    initCardInteractions();
    
    // Animații de intrare pentru conținut
    animateContent();
});

// Inițializează toggle pentru sidebar
function initSidebar() {
    const menuToggle = document.getElementById('menu-toggle');
    const wrapper = document.getElementById('wrapper');
    
    if (menuToggle && wrapper) {
        menuToggle.addEventListener('click', function() {
            wrapper.classList.toggle('toggled');
        });
    }
    
    // Adaugă clase active la elementul selectat din sidebar
    const sidebarItems = document.querySelectorAll('.list-group-item');
    sidebarItems.forEach(item => {
        item.addEventListener('click', function() {
            // Elimină clasa active de pe toate elementele
            sidebarItems.forEach(el => el.classList.remove('active'));
            // Adaugă clasa active pe elementul curent
            this.classList.add('active');
        });
    });
}

// Inițializează tooltips și popovers
function initTooltipsAndPopovers() {
    // Activează toate tooltip-urile
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Activează toate popover-urile
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
}

// Inițializează dropdown-uri
function initDropdowns() {
    const dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl);
    });
}

// Mock data pentru grafice (simulare)
function mockChartData() {
    // Aici poți inițializa un grafic real folosind Chart.js sau altă librărie
    console.log('Grafic inițializat (demo)');
}

// Adaugă efecte de interacțiune pentru carduri
function initCardInteractions() {
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 8px 20px rgba(0, 0, 0, 0.08)';
            this.style.transition = 'all 0.3s ease';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = '';
            this.style.boxShadow = '';
        });
    });
}

// Animează elementele la încărcarea paginii
function animateContent() {
    const stats = document.querySelectorAll('.stat-card');
    const content = document.querySelectorAll('.card');
    
    // Adaugă o întârziere pentru elementele de statistici
    stats.forEach((stat, index) => {
        setTimeout(() => {
            stat.style.opacity = '1';
            stat.style.transform = 'translateY(0)';
        }, 100 * index);
    });
    
    // Adaugă o întârziere mai mare pentru restul conținutului
    content.forEach((item, index) => {
        if (!item.classList.contains('stat-card')) {
            setTimeout(() => {
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
            }, 300 + (50 * index));
        }
    });
}
