// Administrador de contenido promocional
class ContentManager {
    constructor() {
        this.apiUrl = 'data/promotional-text.json';
        this.updateUrl = 'update-content.php'; // Archivo PHP para actualizar el JSON
        this.currentData = null;
        
        this.initializeElements();
        this.bindEvents();
        this.loadContent();
    }

    initializeElements() {
        this.textArea = document.getElementById('promotional-text');
        this.updatedByInput = document.getElementById('updated-by');
        this.activeToggle = document.getElementById('active-toggle');
        this.previewText = document.getElementById('preview-text');
        this.charCounter = document.getElementById('char-counter');
        this.lastUpdated = document.getElementById('last-updated');
        this.version = document.getElementById('version');
        this.statusBadge = document.getElementById('status-badge');
        this.form = document.getElementById('content-form');
        this.resetBtn = document.getElementById('reset-btn');
        this.testApiBtn = document.getElementById('test-api');
    }

    bindEvents() {
        // Formulario
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        this.resetBtn.addEventListener('click', () => this.loadContent());
        this.testApiBtn.addEventListener('click', () => this.testApi());

        // Textarea eventos
        this.textArea.addEventListener('input', () => {
            this.updateCharCounter();
            this.updatePreview();
        });

        // Toggle activo/inactivo
        this.activeToggle.addEventListener('change', () => {
            this.updateStatusBadge();
        });
    }

    async loadContent() {
        try {
            this.showLoading(true);
            
            // Agregar timestamp para evitar cache
            const response = await fetch(`${this.apiUrl}?t=${Date.now()}`);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            this.currentData = data;
                  // Llenar formulario
        this.textArea.value = data.promotional_text || '';
        this.updatedByInput.value = window.currentUser ? window.currentUser.name : (data.updated_by || 'admin');
        this.activeToggle.checked = data.active !== false;
            
            // Actualizar información
            this.updateCharCounter();
            this.updatePreview();
            this.updateSystemInfo();
            this.updateStatusBadge();
            
        } catch (error) {
            console.error('Error cargando contenido:', error);
            this.showToast('error-toast');
            
            // Valores por defecto en caso de error
            this.textArea.value = '¡Tengo una Mega noticia! Hoy tiene la oportunidad de activar MAX de 149 pesos, a tan solo 60 pesos al mes durante 6 meses. ¿Desea aprovechar esta promoción exclusiva?';
            this.updateCharCounter();
            this.updatePreview();
        } finally {
            this.showLoading(false);
        }
    }

    async handleSubmit(e) {
        e.preventDefault();
        
        const submitBtn = e.target.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        try {
            // Mostrar loading en botón
            submitBtn.innerHTML = '<i class="spinner-border spinner-border-sm me-2"></i>Guardando...';
            submitBtn.disabled = true;
            
            const newData = {
                promotional_text: this.textArea.value.trim(),
                last_updated: new Date().toISOString(),
                updated_by: window.currentUser ? window.currentUser.name : (this.updatedByInput.value.trim() || 'admin'),
                version: this.incrementVersion(),
                active: this.activeToggle.checked
            };
            
            // Simular guardado (en un entorno real usarías PHP/backend)
            await this.saveContent(newData);
            
            this.currentData = newData;
            this.updateSystemInfo();
            this.showToast('success-toast');
            
        } catch (error) {
            console.error('Error guardando:', error);
            this.showToast('error-toast');
        } finally {
            // Restaurar botón
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    }

    async saveContent(data) {
        // En un entorno real, esto haría una petición POST a un script PHP
        // Por ahora, simularemos el guardado en localStorage para testing
        
        try {
            // Simular petición al servidor
            const response = await fetch(this.updateUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            });

            if (!response.ok) {
                throw new Error('Error en el servidor');
            }

        } catch (error) {
            // Si no hay servidor PHP, guardar en localStorage para demo
            console.log('Guardando en localStorage (modo demo)');
            localStorage.setItem('promotional-content', JSON.stringify(data));
            
            // Simular delay del servidor
            await new Promise(resolve => setTimeout(resolve, 1000));
        }
    }

    async testApi() {
        const testBtn = this.testApiBtn;
        const originalText = testBtn.innerHTML;
        
        try {
            testBtn.innerHTML = '<i class="spinner-border spinner-border-sm me-2"></i>Probando...';
            testBtn.disabled = true;
            
            const response = await fetch(this.apiUrl + `?t=${Date.now()}`);
            const data = await response.json();
            
            // Mostrar resultado en consola
            console.log('API Test Result:', data);
            
            // Actualizar preview con datos de la API
            this.previewText.textContent = data.promotional_text;
            
            testBtn.classList.remove('btn-outline-primary');
            testBtn.classList.add('btn-outline-success');
            testBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>API OK';
            
            setTimeout(() => {
                testBtn.classList.remove('btn-outline-success');
                testBtn.classList.add('btn-outline-primary');
                testBtn.innerHTML = originalText;
            }, 2000);
            
        } catch (error) {
            console.error('API Test Failed:', error);
            
            testBtn.classList.remove('btn-outline-primary');
            testBtn.classList.add('btn-outline-danger');
            testBtn.innerHTML = '<i class="bi bi-x-circle me-2"></i>Error';
            
            setTimeout(() => {
                testBtn.classList.remove('btn-outline-danger');
                testBtn.classList.add('btn-outline-primary');
                testBtn.innerHTML = originalText;
            }, 2000);
        } finally {
            testBtn.disabled = false;
        }
    }

    updateCharCounter() {
        const length = this.textArea.value.length;
        const maxLength = 500;
        
        this.charCounter.textContent = `${length}/${maxLength}`;
        
        // Cambiar color según proximidad al límite
        this.charCounter.className = 'char-counter';
        if (length > maxLength * 0.9) {
            this.charCounter.classList.add('danger');
        } else if (length > maxLength * 0.7) {
            this.charCounter.classList.add('warning');
        }
    }

    updatePreview() {
        const text = this.textArea.value.trim();
        this.previewText.textContent = text || 'Vista previa del texto...';
    }

    updateSystemInfo() {
        if (this.currentData) {
            // Formatear fecha
            const date = new Date(this.currentData.last_updated);
            const formattedDate = date.toLocaleDateString('es-ES', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            this.lastUpdated.textContent = formattedDate;
            this.version.textContent = `v${this.currentData.version}`;
        }
    }

    updateStatusBadge() {
        const isActive = this.activeToggle.checked;
        
        if (isActive) {
            this.statusBadge.className = 'badge bg-success status-badge';
            this.statusBadge.innerHTML = '<i class="bi bi-check-circle-fill"></i> Activo';
        } else {
            this.statusBadge.className = 'badge bg-warning status-badge';
            this.statusBadge.innerHTML = '<i class="bi bi-pause-circle-fill"></i> Inactivo';
        }
    }

    incrementVersion() {
        if (!this.currentData || !this.currentData.version) {
            return '1.0';
        }
        
        const [major, minor] = this.currentData.version.split('.').map(Number);
        return `${major}.${minor + 1}`;
    }

    showToast(toastId) {
        const toastElement = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastElement);
        toast.show();
    }

    showLoading(show) {
        if (show) {
            this.previewText.innerHTML = '<i class="spinner-border spinner-border-sm me-2"></i>Cargando...';
        }
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    new ContentManager();
    
    // Funcionalidades adicionales para administradores
    if (window.currentUser && window.currentUser.hasAdminPermission) {
        initAdminFeatures();
    }
});

// Funcionalidades adicionales para administradores
function initAdminFeatures() {
    // Ver logs de acceso
    document.getElementById('view-logs')?.addEventListener('click', function() {
        window.open('view-logs.php', '_blank', 'width=800,height=600');
    });
    
    // Gestionar usuarios (placeholder)
    document.getElementById('manage-users')?.addEventListener('click', function() {
        alert('Funcionalidad de gestión de usuarios - Por implementar');
    });
}

// Función auxiliar para recargar la página del call center (para testing)
function reloadCallCenter() {
    if (window.opener) {
        window.opener.location.reload();
    }
}

// Función para verificar sesión activa
function checkSession() {
    fetch('check-session.php')
        .then(response => response.json())
        .then(data => {
            if (!data.authenticated) {
                alert('Su sesión ha expirado. Será redirigido al login.');
                window.location.href = 'login.php';
            }
        })
        .catch(error => {
            console.error('Error verificando sesión:', error);
        });
}

// Verificar sesión cada 5 minutos
setInterval(checkSession, 5 * 60 * 1000);

// Mensaje de bienvenida basado en el rol
if (window.currentUser) {
    console.log(`¡Bienvenido ${window.currentUser.name}! (${window.currentUser.role.toUpperCase()})`);
    
    // Personalizar interfaz según el rol
    if (window.currentUser.role === 'editor') {
        console.log('Permisos de editor: Puede editar contenido');
    } else if (window.currentUser.role === 'supervisor') {
        console.log('Permisos de supervisor: Puede editar contenido y activar/desactivar');
    } else if (window.currentUser.role === 'admin') {
        console.log('Permisos de administrador: Acceso completo');
    }
}
