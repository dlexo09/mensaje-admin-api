# Configuración de Git para el proyecto MEGA Call Center

## 🎯 **Archivos incluidos en el repositorio:**

### ✅ **Archivos importantes:**
- `*.php` - Código fuente PHP
- `*.html` - Páginas web
- `*.js` - Scripts JavaScript
- `*.css` - Hojas de estilo
- `*.json` - Archivos de configuración (excepto sensibles)
- `*.md` - Documentación
- `data/promotional-text.json` - Datos iniciales del sistema

### ❌ **Archivos excluidos:**
- `*backup*` - Todos los archivos de backup
- `*.zip` - Archivos comprimidos
- `*.log` - Logs del sistema
- `data/access-log.txt` - Logs de acceso
- `data/update-log.txt` - Logs de actualizaciones
- `data/*backup*` - Backups en la carpeta data
- Archivos temporales y de caché
- Archivos de configuración sensibles
- Archivos de IDE/editor

## 📋 **Comandos Git recomendados:**

### Inicializar repositorio:
```bash
git init
git add .
git commit -m "Initial commit: MEGA Call Center Admin System"
```

### Verificar archivos ignorados:
```bash
git status --ignored
```

### Agregar archivos específicos:
```bash
git add index.html admin.php auth.php
git commit -m "Add core admin system files"
```

### Ver qué archivos están siendo ignorados:
```bash
git ls-files --others --ignored --exclude-standard
```

## 🔧 **Configuración recomendada:**

### Configurar usuario (primera vez):
```bash
git config --global user.name "Tu Nombre"
git config --global user.email "tu@email.com"
```

### Configurar editor:
```bash
git config --global core.editor "code --wait"
```

### Configurar line endings (Windows):
```bash
git config --global core.autocrlf true
```

## 🚀 **Estructura del proyecto en Git:**

```
mega-landings/call-center/
├── .gitignore              # Archivos a ignorar
├── README.md              # Documentación principal
├── AUTH-SETUP.md          # Guía de autenticación
├── AWS-LAMBDA-SETUP.md    # Guía de AWS Lambda
├── index.html             # Página principal
├── admin.php              # Panel de administración
├── login.php              # Página de login
├── auth.php               # Sistema de autenticación
├── admin-script.js        # JavaScript del admin
├── update-content.php     # API de actualización
├── check-session.php      # Verificador de sesión
├── view-logs.php          # Visualizador de logs
├── clear-logs.php         # Limpiador de logs
├── style.css              # Estilos principales
├── mega-colors.css        # Colores de MEGA
├── lambda-function-example.js  # Ejemplo de Lambda
├── data/
│   ├── .gitkeep          # Mantiene la carpeta
│   └── promotional-text.json  # Datos iniciales
└── assets/
    └── bg-principal.png  # Imagen de fondo
```

## 🔐 **Seguridad:**

Los siguientes archivos están excluidos por seguridad:
- Logs de acceso y actualizaciones
- Backups automáticos
- Archivos de configuración sensibles
- Archivos de sesiones PHP
- Credenciales y secretos

## 📝 **Notas importantes:**

1. **Backups**: Los archivos de backup no se versionan, pero se mantienen localmente
2. **Logs**: Los logs se generan automáticamente y no deben versionarse
3. **Configuración**: Solo se incluyen archivos de configuración de ejemplo
4. **Datos**: Solo se incluye el archivo JSON inicial, no los backups

## 🆘 **Troubleshooting:**

### Si un archivo importante fue ignorado:
```bash
git add -f archivo-importante.php
```

### Para ver todos los archivos ignorados:
```bash
git status --ignored
```

### Para limpiar archivos no trackeados:
```bash
git clean -fd
```
