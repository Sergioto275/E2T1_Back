@echo off
setlocal

:: Definir las URL de los repositorios de GitHub
set REPO_URL_1=https://github.com/Sergioto275/E2T1_Back.git
set REPO_URL_2=https://github.com/Sergioto275/E2T1_Front.git
set REPO_NAME_1=Back
set REPO_NAME_2=Front

:: Definir la ubicación donde se clonarán los repositorios
set CLONE_DIR=C:\xampp\htdocs\erronka2
set REPO_DIR_1=%CLONE_DIR%\%REPO_NAME_1%
set REPO_DIR_2=%CLONE_DIR%\%REPO_NAME_2%

:: Crear el directorio de clonación si no existe
if not exist "%CLONE_DIR%" (
    echo Creando directorio %CLONE_DIR%
    mkdir "%CLONE_DIR%"
    if %errorlevel% neq 0 (
        echo Error al crear el directorio de clonación %CLONE_DIR%
        pause
        goto :eof
    )
)

:: Definir la URL que se abrirá en el navegador
set URL=http://localhost/erronka2/Front/Login.html

:: Archivo de registro
set LOGFILE=%CLONE_DIR%\script_log.txt

:: Limpiar el archivo de registro
echo Script iniciado > %LOGFILE%

:: Clonar o actualizar los repositorios uno por uno
call :clone_or_update_repo "%REPO_URL_1%" "%REPO_DIR_1%" "%REPO_NAME_1%"
call :clone_or_update_repo "%REPO_URL_2%" "%REPO_DIR_2%" "%REPO_NAME_2%"

:: Activar los servicios de MySQL y Apache
echo Iniciando MySQL y Apache >> %LOGFILE%
start "" "C:\xampp\xampp_start.exe"
if %errorlevel% neq 0 (
    echo Error al iniciar MySQL y Apache >> %LOGFILE%
    echo Error al iniciar MySQL y Apache
    pause
    goto :eof
)

:: Esperar unos segundos para que los servicios se inicien
timeout /t 10 /nobreak

:: Abrir la dirección URL en el navegador predeterminado
echo Abriendo URL %URL% >> %LOGFILE%
start "" "%URL%"
if %errorlevel% neq 0 (
    echo Error al abrir la URL %URL% >> %LOGFILE%
    echo Error al abrir la URL %URL%
    pause
    goto :eof
)

echo Script completado >> %LOGFILE%
echo Script completado
pause
endlocal
goto :eof

:clone_or_update_repo
:: Parámetros de la función
set REPO_URL=%1
set REPO_DIR=%2
set REPO_NAME=%3

if not exist "%REPO_DIR%\.git" (
    echo Clonando %REPO_NAME% en %REPO_DIR% >> %LOGFILE%
    echo Clonando %REPO_NAME% en %REPO_DIR%
    git clone "%REPO_URL%" "%REPO_DIR%" >> %LOGFILE% 2>&1
    if %errorlevel% neq 0 (
        echo Error al clonar el repositorio %REPO_NAME% >> %LOGFILE%
        echo Error al clonar el repositorio %REPO_NAME%
        pause
        goto :eof
    )
) else (
    echo Actualizando %REPO_NAME% en %REPO_DIR% >> %LOGFILE%
    echo Actualizando %REPO_NAME% en %REPO_DIR%
    cd /d "%REPO_DIR%"
    git pull origin master >> %LOGFILE% 2>&1
    if %errorlevel% neq 0 (
        echo Error al actualizar el repositorio %REPO_NAME% >> %LOGFILE%
        echo Error al actualizar el repositorio %REPO_NAME%
        pause
        goto :eof
    )
)
exit /b 0