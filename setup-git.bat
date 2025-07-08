@echo off
REM Script de configuración automática para repositorio remoto MEGA Call Center
REM Ejecutar desde: c:\xampp\htdocs\mega-landings\call-center\

echo ============================================
echo   MEGA Call Center - Configuracion Git
echo ============================================
echo.

REM Verificar si estamos en la carpeta correcta
if not exist "admin.php" (
    echo ERROR: Ejecuta este script desde la carpeta del proyecto
    echo Ubicacion correcta: c:\xampp\htdocs\mega-landings\call-center\
    pause
    exit /b 1
)

REM Verificar si Git está instalado
git --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ERROR: Git no está instalado o no está en el PATH
    echo Descarga Git desde: https://git-scm.com/download/win
    pause
    exit /b 1
)

echo [1/8] Verificando Git... OK
echo.

REM Configurar usuario si no está configurado
for /f "tokens=*" %%i in ('git config user.name') do set username=%%i
for /f "tokens=*" %%i in ('git config user.email') do set useremail=%%i

if "%username%"=="" (
    set /p username="Ingresa tu nombre para Git: "
    git config user.name "%username%"
)

if "%useremail%"=="" (
    set /p useremail="Ingresa tu email para Git: "
    git config user.email "%useremail%"
)

echo [2/8] Configurando usuario Git... OK
echo Usuario: %username%
echo Email: %useremail%
echo.

REM Inicializar repositorio si no existe
if not exist ".git" (
    echo [3/8] Inicializando repositorio Git...
    git init
    echo Repositorio inicializado
) else (
    echo [3/8] Repositorio Git ya existe... OK
)
echo.

REM Agregar archivos
echo [4/8] Agregando archivos al repositorio...
git add .
echo Archivos agregados (respetando .gitignore)
echo.

REM Verificar si hay cambios para commitear
git diff --cached --quiet
if %errorlevel% neq 0 (
    echo [5/8] Realizando commit inicial...
    git commit -m "Initial commit: MEGA Call Center Admin System

- Sistema de autenticacion con roles (admin, supervisor, editor)
- Panel de administracion con interfaz moderna
- API para gestion de contenido promocional
- Sistema de logs y backups automaticos
- Diseño responsive con colores corporativos MEGA"
    echo Commit realizado
) else (
    echo [5/8] No hay cambios para commitear... OK
)
echo.

REM Configurar remoto
echo [6/8] Configurando repositorio remoto...
echo.
echo Selecciona la plataforma de Git:
echo 1. GitHub
echo 2. GitLab
echo 3. Bitbucket
echo 4. Otro (manual)
echo.
set /p platform="Ingresa tu opcion (1-4): "

if "%platform%"=="1" (
    set /p repo_url="Ingresa la URL del repositorio GitHub (ej: https://github.com/usuario/repo.git): "
    set platform_name=GitHub
) else if "%platform%"=="2" (
    set /p repo_url="Ingresa la URL del repositorio GitLab (ej: https://gitlab.com/usuario/repo.git): "
    set platform_name=GitLab
) else if "%platform%"=="3" (
    set /p repo_url="Ingresa la URL del repositorio Bitbucket (ej: https://bitbucket.org/usuario/repo.git): "
    set platform_name=Bitbucket
) else (
    set /p repo_url="Ingresa la URL del repositorio: "
    set platform_name=Personalizado
)

REM Verificar si ya existe un remoto
git remote get-url origin >nul 2>&1
if %errorlevel% equ 0 (
    echo Remoto existente encontrado, eliminando...
    git remote remove origin
)

REM Agregar nuevo remoto
git remote add origin %repo_url%
echo Repositorio remoto agregado: %platform_name%
echo.

REM Verificar remoto
echo [7/8] Verificando configuracion...
git remote -v
echo.

REM Subir al repositorio remoto
echo [8/8] Subiendo codigo al repositorio remoto...
echo.
echo IMPORTANTE: Necesitaras tu token de acceso personal o contraseña
echo Para %platform_name%: Ve a Settings > Developer settings > Personal access tokens
echo.
set /p confirm="¿Continuar con el push? (s/n): "

if /i "%confirm%"=="s" (
    git branch -M main
    git push -u origin main
    echo.
    echo ============================================
    echo   CONFIGURACION COMPLETADA EXITOSAMENTE
    echo ============================================
    echo.
    echo Repositorio: %repo_url%
    echo Plataforma: %platform_name%
    echo Usuario: %username%
    echo Email: %useremail%
    echo.
    echo Comandos utiles:
    echo - git status          : Ver estado del repositorio
    echo - git add .           : Agregar cambios
    echo - git commit -m "msg" : Realizar commit
    echo - git push            : Subir cambios
    echo - git pull            : Descargar cambios
    echo.
) else (
    echo.
    echo Configuracion completada (sin push)
    echo Para subir manualmente: git push -u origin main
    echo.
)

echo Presiona cualquier tecla para continuar...
pause >nul
