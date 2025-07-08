# 🔐 Sistema de Autenticación - MEGA Call Center Admin

## ✅ **Sistema implementado exitosamente**

Se ha creado un sistema de autenticación completo con las siguientes características:

### 🎯 **Componentes implementados:**

1. **`auth.php`** - Sistema de autenticación y sesiones
2. **`login.php`** - Página de login con diseño moderno
3. **`admin.php`** - Panel de administración protegido (renombrado desde admin.html)
4. **`check-session.php`** - Verificador de sesión activa
5. **`view-logs.php`** - Visualizador de logs (solo administradores)
6. **`clear-logs.php`** - Limpiador de logs (solo administradores)
7. **`update-content.php`** - API actualizada con autenticación

### 👥 **Usuarios predefinidos:**

| Usuario | Contraseña | Rol | Permisos |
|---------|------------|-----|----------|
| `admin` | `admin123` | Admin | Todos los permisos |
| `supervisor` | `super123` | Supervisor | Editar contenido + activar/desactivar |
| `editor` | `editor123` | Editor | Solo editar contenido |

### 🛡️ **Características de seguridad:**

- ✅ **Autenticación basada en sesiones** PHP
- ✅ **Contraseñas hasheadas** con `password_hash()`
- ✅ **Sistema de roles** (admin, supervisor, editor)
- ✅ **Protección de páginas** con `requireAuth()`
- ✅ **Verificación de permisos** granular
- ✅ **Logs de acceso** y actividad
- ✅ **Timeout de sesión** (24 horas)
- ✅ **Recordar usuario** (30 días)
- ✅ **Logs de intentos fallidos**

### 🚀 **Cómo usar:**

1. **Acceder al sistema:**
   ```
   http://localhost/mega-landings/call-center/login.php
   ```

2. **Usar credenciales de prueba:**
   - Admin: `admin` / `admin123`
   - Supervisor: `supervisor` / `super123`
   - Editor: `editor` / `editor123`

3. **Gestionar contenido:**
   - Todos los usuarios pueden editar texto promocional
   - Solo supervisores y admins pueden activar/desactivar contenido
   - Solo admins pueden ver logs y gestionar usuarios

### 📋 **Permisos por rol:**

#### **Editor** 🟢
- ✅ Editar texto promocional
- ✅ Ver vista previa
- ✅ Probar API
- ❌ Activar/desactivar contenido
- ❌ Ver logs
- ❌ Gestionar usuarios

#### **Supervisor** 🟡
- ✅ Todas las funciones del Editor
- ✅ Activar/desactivar contenido
- ❌ Ver logs
- ❌ Gestionar usuarios

#### **Admin** 🔴
- ✅ Todas las funciones del Supervisor
- ✅ Ver logs de acceso y actualizaciones
- ✅ Limpiar logs
- ✅ Gestionar usuarios (funcionalidad por implementar)

### 🔧 **Configuración adicional:**

#### **Cambiar contraseñas:**
Edita el array `$users` en `auth.php`:
```php
$users = [
    'admin' => [
        'password' => password_hash('nueva_contraseña', PASSWORD_DEFAULT),
        'name' => 'Administrador',
        'role' => 'admin'
    ]
];
```

#### **Agregar nuevos usuarios:**
```php
'nuevo_usuario' => [
    'password' => password_hash('contraseña', PASSWORD_DEFAULT),
    'name' => 'Nombre Completo',
    'role' => 'editor' // o 'supervisor' o 'admin'
]
```

#### **Configurar timeout de sesión:**
En `auth.php`, modifica:
```php
$sessionTimeout = 24 * 60 * 60; // 24 horas en segundos
```

### 📊 **Funcionalidades adicionales:**

#### **Logs automáticos:**
- **`data/access-log.txt`** - Logs de login/logout
- **`data/update-log.txt`** - Logs de actualizaciones de contenido

#### **Backups automáticos:**
- Se crean backups del JSON antes de cada actualización
- Se mantienen los últimos 5 backups automáticamente

#### **Verificación de sesión:**
- Cada 5 minutos se verifica que la sesión esté activa
- Redirección automática al login si expira

### 🔄 **Migración desde la versión anterior:**

El sistema es completamente compatible con la versión anterior. Los cambios principales:

1. **`admin.html`** → **`admin.php`** (con autenticación)
2. **`update-content.php`** actualizado con autenticación
3. **Nuevos archivos** de autenticación agregados

### 🆘 **Troubleshooting:**

#### **Error "No autenticado":**
- Asegúrate de hacer login primero
- Verifica que las sesiones PHP estén habilitadas

#### **Error "Permisos insuficientes":**
- Verifica el rol del usuario
- Algunos usuarios no pueden activar/desactivar contenido

#### **No puedo acceder a logs:**
- Solo los administradores pueden ver logs
- Usa la cuenta `admin` / `admin123`

### 💡 **Próximas mejoras sugeridas:**

1. **Base de datos** para usuarios (en lugar de array)
2. **Recuperación de contraseñas** por email
3. **Autenticación de dos factores** (2FA)
4. **API para gestión de usuarios**
5. **Auditoría más detallada**
6. **Notificaciones por email** de cambios

---

## 🎉 **¡Sistema listo para usar!**

El sistema de autenticación está completamente funcional y listo para producción. Puedes acceder con las credenciales de prueba y comenzar a gestionar el contenido de forma segura.

**URL de acceso:** `http://localhost/mega-landings/call-center/login.php`
