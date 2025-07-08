#!/bin/bash
# Script de configuración automática para repositorio remoto MEGA Call Center

echo "============================================"
echo "   MEGA Call Center - Configuracion Git"
echo "============================================"
echo

# Verificar si estamos en la carpeta correcta
if [ ! -f "admin.php" ]; then
    echo "ERROR: Ejecuta este script desde la carpeta del proyecto"
    echo "Ubicacion correcta: /path/to/mega-landings/call-center/"
    exit 1
fi

# Verificar si Git está instalado
if ! command -v git &> /dev/null; then
    echo "ERROR: Git no está instalado"
    echo "Instala Git desde: https://git-scm.com/download"
    exit 1
fi

echo "[1/8] Verificando Git... OK"
echo

# Configurar usuario si no está configurado
username=$(git config user.name)
useremail=$(git config user.email)

if [ -z "$username" ]; then
    read -p "Ingresa tu nombre para Git: " username
    git config user.name "$username"
fi

if [ -z "$useremail" ]; then
    read -p "Ingresa tu email para Git: " useremail
    git config user.email "$useremail"
fi

echo "[2/8] Configurando usuario Git... OK"
echo "Usuario: $username"
echo "Email: $useremail"
echo

# Inicializar repositorio si no existe
if [ ! -d ".git" ]; then
    echo "[3/8] Inicializando repositorio Git..."
    git init
    echo "Repositorio inicializado"
else
    echo "[3/8] Repositorio Git ya existe... OK"
fi
echo

# Agregar archivos
echo "[4/8] Agregando archivos al repositorio..."
git add .
echo "Archivos agregados (respetando .gitignore)"
echo

# Verificar si hay cambios para commitear
if ! git diff --cached --quiet; then
    echo "[5/8] Realizando commit inicial..."
    git commit -m "Initial commit: MEGA Call Center Admin System

- Sistema de autenticacion con roles (admin, supervisor, editor)
- Panel de administracion con interfaz moderna
- API para gestion de contenido promocional
- Sistema de logs y backups automaticos
- Diseño responsive con colores corporativos MEGA"
    echo "Commit realizado"
else
    echo "[5/8] No hay cambios para commitear... OK"
fi
echo

# Configurar remoto
echo "[6/8] Configurando repositorio remoto..."
echo
echo "Selecciona la plataforma de Git:"
echo "1. GitHub"
echo "2. GitLab"
echo "3. Bitbucket"
echo "4. Otro (manual)"
echo
read -p "Ingresa tu opcion (1-4): " platform

case $platform in
    1)
        read -p "Ingresa la URL del repositorio GitHub (ej: https://github.com/usuario/repo.git): " repo_url
        platform_name="GitHub"
        ;;
    2)
        read -p "Ingresa la URL del repositorio GitLab (ej: https://gitlab.com/usuario/repo.git): " repo_url
        platform_name="GitLab"
        ;;
    3)
        read -p "Ingresa la URL del repositorio Bitbucket (ej: https://bitbucket.org/usuario/repo.git): " repo_url
        platform_name="Bitbucket"
        ;;
    *)
        read -p "Ingresa la URL del repositorio: " repo_url
        platform_name="Personalizado"
        ;;
esac

# Verificar si ya existe un remoto
if git remote get-url origin &> /dev/null; then
    echo "Remoto existente encontrado, eliminando..."
    git remote remove origin
fi

# Agregar nuevo remoto
git remote add origin "$repo_url"
echo "Repositorio remoto agregado: $platform_name"
echo

# Verificar remoto
echo "[7/8] Verificando configuracion..."
git remote -v
echo

# Subir al repositorio remoto
echo "[8/8] Subiendo codigo al repositorio remoto..."
echo
echo "IMPORTANTE: Necesitaras tu token de acceso personal o contraseña"
echo "Para $platform_name: Ve a Settings > Developer settings > Personal access tokens"
echo
read -p "¿Continuar con el push? (s/n): " confirm

if [[ $confirm =~ ^[Ss]$ ]]; then
    git branch -M main
    git push -u origin main
    echo
    echo "============================================"
    echo "   CONFIGURACION COMPLETADA EXITOSAMENTE"
    echo "============================================"
    echo
    echo "Repositorio: $repo_url"
    echo "Plataforma: $platform_name"
    echo "Usuario: $username"
    echo "Email: $useremail"
    echo
    echo "Comandos utiles:"
    echo "- git status          : Ver estado del repositorio"
    echo "- git add .           : Agregar cambios"
    echo "- git commit -m \"msg\" : Realizar commit"
    echo "- git push            : Subir cambios"
    echo "- git pull            : Descargar cambios"
    echo
else
    echo
    echo "Configuracion completada (sin push)"
    echo "Para subir manualmente: git push -u origin main"
    echo
fi

echo "Presiona Enter para continuar..."
read
