# Call Center Landing - Sistema de Administración Local

Este proyecto incluye un **administrador web simple** para gestionar el contenido promocional del call center usando archivos JSON locales.

## 🎯 **Características principales**

- ✅ **Administrador web** intuitivo y moderno
- ✅ **Archivo JSON** para almacenar el contenido
- ✅ **API simulada** local (sin necesidad de Lambda)
- ✅ **Editor en tiempo real** con vista previa
- ✅ **Sistema de versiones** automático
- ✅ **Backups automáticos** de contenido
- ✅ **Activar/desactivar** contenido
- ✅ **Contador de caracteres** con límites
- ✅ **Responsive design** con Bootstrap

## 📁 **Estructura de archivos**

```
call-center/
├── index.html                    # Página principal del call center
├── admin.html                    # Panel de administración
├── admin-script.js               # JavaScript del administrador
├── update-content.php            # API para actualizar contenido
├── style.css                     # Estilos CSS del call center
├── data/
│   ├── promotional-text.json     # Contenido promocional
│   ├── promotional-text-backup-*.json  # Backups automáticos
│   └── update-log.txt            # Log de actualizaciones
├── assets/
│   └── bg-principal.png         # Imagen de fondo
└── README.md                    # Este archivo
```

## 🚀 **Instalación y configuración**

### 1. **Requisitos**
- Servidor web local (XAMPP, WAMP, MAMP, etc.)
- PHP 7.4 o superior
- Navegador web moderno

### 2. **Configuración inicial**
1. Copia todos los archivos al directorio de tu servidor web
2. Asegúrate de que PHP tenga permisos de escritura en la carpeta `data/`
3. Accede a `http://localhost/mega-landings/call-center/`

### 3. **Acceso al administrador**
- URL: `http://localhost/mega-landings/call-center/admin.html`
- No requiere autenticación (agregar según necesidades)

## 📝 **Cómo usar el administrador**

### **Editor de contenido**
1. Abre `admin.html` en tu navegador
2. Edita el texto promocional en el textarea
3. Configura el nombre del usuario que actualiza
4. Activa/desactiva el contenido con el toggle
5. Haz clic en **"Guardar Cambios"**

### **Vista previa**
- Se actualiza automáticamente mientras escribes
- Muestra cómo se verá en el call center
- Información del sistema (versión, última actualización)

### **Funciones adicionales**
- **Recargar**: Restaura el contenido desde el JSON
- **Probar API**: Verifica que el JSON se esté leyendo correctamente
- **Contador de caracteres**: Límite de 500 caracteres con avisos visuales

## 🔧 **API Local**

### **Leer contenido** (GET)
```
URL: data/promotional-text.json
Respuesta:
{
  "promotional_text": "Texto promocional aquí",
  "last_updated": "2025-07-08T10:30:00.000Z",
  "updated_by": "admin",
  "version": "1.0",
  "active": true
}
```

### **Actualizar contenido** (POST)
```
URL: update-content.php
Body: JSON con el nuevo contenido
Respuesta: Confirmación de éxito/error
```

## 🛡️ **Características de seguridad**

### **Validaciones incluidas**
- ✅ Límite de 500 caracteres
- ✅ Validación de campos requeridos
- ✅ Sanitización de datos
- ✅ Backups automáticos antes de guardar
- ✅ Log de todas las actualizaciones
- ✅ Manejo de errores robusto

### **Mejoras de seguridad recomendadas**
- 🔒 Agregar autenticación al administrador
- 🔒 Validar permisos de usuario
- 🔒 Implementar CSRF protection
- 🔒 Encriptar datos sensibles

## 🧪 **Testing y desarrollo**

### **Probar localmente**
1. Abre `index.html` → Página del call center
2. Abre `admin.html` → Panel de administración
3. Edita el contenido en el admin
4. Recarga `index.html` para ver los cambios

### **Debugging**
- Revisa la consola del navegador para logs
- Verifica el archivo `data/update-log.txt` para operaciones
- Los errores de PHP se registran en el log del servidor

## 📊 **Ventajas vs Lambda**

| Característica | JSON Local | AWS Lambda |
|---|---|---|
| **Costo** | 🟢 Gratis | 🟡 Muy bajo |
| **Velocidad** | 🟢 Instantáneo | 🟡 ~100ms |
| **Administración** | 🟢 Panel web incluido | 🔴 Requiere AWS Console |
| **Simplicidad** | 🟢 Muy simple | 🟡 Requiere configuración AWS |
| **Escalabilidad** | 🟡 Limitada | 🟢 Ilimitada |
| **Offline** | 🟢 Funciona sin internet | 🔴 Requiere internet |

## 🚀 **Migración a Lambda (opcional)**

Si posteriormente quieres migrar a AWS Lambda:
1. Mantén todos los archivos actuales
2. Cambia `JSON_API_URL` en `index.html` por la URL de Lambda
3. El administrador seguirá funcionando con el JSON local
4. Los archivos de Lambda están en `lambda-function-example.js`

## 📞 **Soporte y mantenimiento**

### **Backup manual**
- Los archivos se respaldan automáticamente en `data/`
- Puedes hacer backup manual copiando la carpeta `data/`

### **Logs**
- Actualizaciones: `data/update-log.txt`
- Errores PHP: Log del servidor web
- Errores JavaScript: Consola del navegador

### **Monitoreo**
- Verifica que el archivo JSON se esté actualizando
- Controla el tamaño del directorio de backups
- Revisa logs periódicamente
