# 📋 Comandos Git - Referencia Rápida

## 🚀 **Comandos básicos diarios**

```bash
# Ver estado del repositorio
git status

# Agregar cambios específicos
git add admin.php auth.php
git add .

# Hacer commit
git commit -m "Update: Improve admin interface"

# Subir cambios
git push

# Descargar cambios del remoto
git pull
```

## 🔧 **Comandos de configuración**

```bash
# Ver configuración actual
git config --list

# Configurar usuario
git config user.name "Tu Nombre"
git config user.email "tu@email.com"

# Ver remotos configurados
git remote -v

# Cambiar URL del remoto
git remote set-url origin https://github.com/usuario/nuevo-repo.git
```

## 📝 **Comandos de información**

```bash
# Ver historial de commits
git log --oneline
git log --graph --oneline --all

# Ver diferencias
git diff
git diff --cached

# Ver archivos en el repositorio
git ls-files

# Ver archivos ignorados
git status --ignored
```

## 🔄 **Comandos de sincronización**

```bash
# Descargar cambios sin merge
git fetch

# Descargar y hacer merge
git pull origin main

# Subir cambios
git push origin main

# Subir una rama específica
git push origin nombre-rama
```

## 🌿 **Comandos de ramas**

```bash
# Ver ramas
git branch
git branch -a

# Crear nueva rama
git checkout -b nueva-funcionalidad

# Cambiar de rama
git checkout main

# Mergear rama
git merge nueva-funcionalidad

# Eliminar rama
git branch -d nueva-funcionalidad
```

## 🆘 **Comandos de emergencia**

```bash
# Deshacer último commit (mantener cambios)
git reset --soft HEAD~1

# Deshacer cambios no commitados
git checkout -- .

# Limpiar archivos no trackeados
git clean -fd

# Cambiar mensaje del último commit
git commit --amend -m "Nuevo mensaje"

# Volver a un commit específico
git reset --hard COMMIT_HASH
```

## 📊 **Comandos de análisis**

```bash
# Ver tamaño del repositorio
git count-objects -vH

# Ver archivos más grandes
git ls-files | xargs ls -la | sort -k5 -rn | head -10

# Ver estadísticas de commits
git shortlog -sn

# Ver cambios por autor
git log --author="Tu Nombre" --oneline
```

## 🏷️ **Comandos de tags**

```bash
# Crear tag
git tag -a v1.0 -m "Version 1.0"

# Ver tags
git tag

# Subir tags
git push origin --tags

# Eliminar tag
git tag -d v1.0
```

## 🔐 **Comandos de seguridad**

```bash
# Ver archivos sensibles que podrían estar trackeados
git log --all --full-history -- "*.env"

# Limpiar historial de un archivo sensible
git filter-branch --force --index-filter \
  'git rm --cached --ignore-unmatch archivo-sensible.txt' \
  --prune-empty --tag-name-filter cat -- --all
```

## 🎯 **Comandos específicos para el proyecto**

```bash
# Verificar que .gitignore funciona
git check-ignore -v data/access-log.txt
git check-ignore -v data/promotional-text-backup-*.json

# Ver archivos que serán ignorados
git ls-files --others --ignored --exclude-standard

# Forzar agregar archivo ignorado (si es necesario)
git add -f archivo-importante.php

# Ver solo archivos PHP
git ls-files "*.php"

# Commit rápido para el proyecto
git add . && git commit -m "Update: $(date +'%Y-%m-%d %H:%M') - Admin improvements"
```

## 🚀 **Flujo de trabajo recomendado**

```bash
# 1. Verificar estado
git status

# 2. Descargar cambios
git pull

# 3. Hacer cambios en archivos...

# 4. Verificar cambios
git diff

# 5. Agregar cambios
git add .

# 6. Commitear
git commit -m "Descripción clara del cambio"

# 7. Subir cambios
git push

# 8. Verificar que se subió
git status
```

## 💡 **Aliases útiles**

```bash
# Configurar aliases
git config --global alias.st status
git config --global alias.co checkout
git config --global alias.br branch
git config --global alias.ci commit
git config --global alias.lg "log --oneline --graph --decorate --all"
git config --global alias.unstage "reset HEAD --"
git config --global alias.last "log -1 HEAD"

# Usar aliases
git st    # En lugar de git status
git lg    # Log gráfico
git ci -m "mensaje"  # Commit
```

## 🎨 **Comandos para el tema MEGA**

```bash
# Commit con formato estándar del proyecto
git commit -m "Add: Nueva funcionalidad de autenticación
- Agregado sistema de roles
- Mejorada interfaz de login
- Implementados colores corporativos MEGA"

# Tag de versión
git tag -a v1.0-mega -m "MEGA Call Center Admin v1.0
- Sistema completo de administración
- Autenticación multicapa
- Interfaz corporativa"

# Ver commits relacionados con MEGA
git log --grep="MEGA" --oneline
```

## 🔧 **Solución de problemas frecuentes**

```bash
# Error: "Your branch is ahead of 'origin/main'"
git push

# Error: "Your branch is behind 'origin/main'"
git pull

# Error: "Cannot push non-fast-forward"
git pull --rebase

# Error: "Merge conflict"
# 1. Editar archivos conflictivos
# 2. git add archivo-resuelto.php
# 3. git commit

# Deshacer merge conflict
git merge --abort

# Ver configuración del repositorio
git config --list --show-origin
```

---

## 📚 **Recursos adicionales**

- **Git Cheat Sheet**: https://education.github.com/git-cheat-sheet-education.pdf
- **Interactive Git Tutorial**: https://learngitbranching.js.org/
- **Pro Git Book**: https://git-scm.com/book
