# 🚀 Configuración de Repositorio Remoto - MEGA Call Center

## 📋 **Pasos para agregar repositorio remoto**

### 1. **Crear repositorio en la plataforma**

#### **GitHub:**
1. Ve a https://github.com
2. Clic en **"New repository"**
3. Nombre: `mega-call-center-admin`
4. Descripción: `Sistema de administración para call center de MEGA`
5. Selecciona **Private** o **Public**
6. **NO** marques "Initialize with README" (ya tenemos archivos)
7. Clic en **"Create repository"**

#### **GitLab:**
1. Ve a https://gitlab.com
2. Clic en **"New project"**
3. Nombre: `mega-call-center-admin`
4. Descripción: `Sistema de administración para call center de MEGA`
5. Nivel de visibilidad: **Private** o **Public**
6. **NO** marques "Initialize repository with a README"
7. Clic en **"Create project"**

### 2. **Configurar Git local**

```bash
# Navegar a la carpeta del proyecto
cd c:\xampp\htdocs\mega-landings\call-center

# Inicializar repositorio (si no está inicializado)
git init

# Configurar usuario (primera vez)
git config user.name "Tu Nombre"
git config user.email "tu@email.com"

# Agregar todos los archivos respetando .gitignore
git add .

# Primer commit
git commit -m "Initial commit: MEGA Call Center Admin System

- Sistema de autenticación con roles (admin, supervisor, editor)
- Panel de administración con interfaz moderna
- API para gestión de contenido promocional
- Sistema de logs y backups automáticos
- Diseño responsive con colores corporativos MEGA"
```

### 3. **Agregar repositorio remoto**

#### **Para GitHub:**
```bash
# Agregar remoto
git remote add origin https://github.com/TU_USUARIO/mega-call-center-admin.git

# Verificar remoto
git remote -v

# Subir código
git push -u origin main
```

#### **Para GitLab:**
```bash
# Agregar remoto
git remote add origin https://gitlab.com/TU_USUARIO/mega-call-center-admin.git

# Verificar remoto
git remote -v

# Subir código
git push -u origin main
```

#### **Para otros servicios:**
```bash
# Bitbucket
git remote add origin https://bitbucket.org/TU_USUARIO/mega-call-center-admin.git

# Azure DevOps
git remote add origin https://dev.azure.com/TU_ORGANIZACION/TU_PROYECTO/_git/mega-call-center-admin

# Servidor propio
git remote add origin https://tu-servidor.com/git/mega-call-center-admin.git
```

### 4. **Verificar configuración**

```bash
# Ver estado del repositorio
git status

# Ver remotos configurados
git remote -v

# Ver historial de commits
git log --oneline

# Ver archivos ignorados
git status --ignored
```

### 5. **Comandos útiles para el flujo de trabajo**

```bash
# Verificar cambios
git status

# Agregar archivos específicos
git add admin.php auth.php

# Commit con mensaje descriptivo
git commit -m "Update: Improve authentication system"

# Subir cambios
git push origin main

# Descargar cambios (si trabajas en equipo)
git pull origin main

# Ver diferencias
git diff

# Ver archivos en el repositorio
git ls-files
```

### 6. **Estructura recomendada de commits**

```bash
# Nuevas funcionalidades
git commit -m "Add: User role management system"

# Corrección de errores
git commit -m "Fix: Session timeout issue in admin panel"

# Actualizaciones
git commit -m "Update: Change color scheme to MEGA blue"

# Documentación
git commit -m "Docs: Add deployment guide"

# Configuración
git commit -m "Config: Update .gitignore for production"
```

### 7. **Configuración adicional recomendada**

```bash
# Configurar editor por defecto
git config --global core.editor "code --wait"

# Configurar line endings (Windows)
git config --global core.autocrlf true

# Configurar colores
git config --global color.ui auto

# Configurar alias útiles
git config --global alias.st status
git config --global alias.co checkout
git config --global alias.br branch
git config --global alias.ci commit
git config --global alias.lg "log --oneline --graph --decorate --all"
```

### 8. **Autenticación**

#### **Token de acceso personal (recomendado):**

**GitHub:**
1. Ve a Settings → Developer settings → Personal access tokens
2. Generate new token (classic)
3. Selecciona scope: `repo`
4. Copia el token
5. Úsalo como contraseña al hacer push

**GitLab:**
1. Ve a User Settings → Access Tokens
2. Crea token con scope: `read_repository`, `write_repository`
3. Úsalo como contraseña

#### **SSH (alternativa):**
```bash
# Generar clave SSH
ssh-keygen -t rsa -b 4096 -C "tu@email.com"

# Agregar a ssh-agent
ssh-add ~/.ssh/id_rsa

# Copiar clave pública (agregar en GitHub/GitLab)
cat ~/.ssh/id_rsa.pub

# Usar URL SSH
git remote set-url origin git@github.com:TU_USUARIO/mega-call-center-admin.git
```

### 9. **Resolver problemas comunes**

#### **Error: "remote origin already exists"**
```bash
# Ver remotos actuales
git remote -v

# Eliminar remoto existente
git remote remove origin

# Agregar nuevo remoto
git remote add origin https://github.com/TU_USUARIO/mega-call-center-admin.git
```

#### **Error: "failed to push some refs"**
```bash
# Forzar push (primera vez)
git push -u origin main --force

# O sincronizar primero
git pull origin main --allow-unrelated-histories
git push -u origin main
```

#### **Error de autenticación**
```bash
# Verificar configuración
git config --list

# Actualizar credenciales
git config credential.helper store
```

### 10. **Comandos de emergencia**

```bash
# Deshacer último commit (mantener cambios)
git reset --soft HEAD~1

# Deshacer cambios no commitados
git checkout -- .

# Ver qué se subirá
git diff --cached

# Limpiar archivos no trackeados
git clean -fd

# Cambiar mensaje del último commit
git commit --amend -m "Nuevo mensaje"
```

## 🎯 **Ejemplo completo**

```bash
# 1. Inicializar y configurar
cd c:\xampp\htdocs\mega-landings\call-center
git init
git config user.name "Desarrollador MEGA"
git config user.email "dev@mega.com"

# 2. Agregar archivos
git add .
git commit -m "Initial commit: MEGA Call Center Admin System"

# 3. Conectar con GitHub
git remote add origin https://github.com/mega-company/call-center-admin.git
git branch -M main
git push -u origin main

# 4. Verificar
git status
git remote -v
```

## 📚 **Recursos adicionales**

- **GitHub Docs**: https://docs.github.com/
- **GitLab Docs**: https://docs.gitlab.com/
- **Git Cheat Sheet**: https://education.github.com/git-cheat-sheet-education.pdf
- **Pro Git Book**: https://git-scm.com/book

## 🔐 **Seguridad**

- ✅ Usa tokens de acceso personal en lugar de contraseñas
- ✅ Configura el repositorio como privado si contiene datos sensibles
- ✅ Revisa el .gitignore antes del primer push
- ✅ No commits archivos de configuración con credenciales

¿Necesitas ayuda con algún paso específico o tienes alguna plataforma de Git en mente?
