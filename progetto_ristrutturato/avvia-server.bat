@echo off
title Avvio Server Django

echo Attivazione dell'ambiente virtuale...
call "venv\Scripts\activate.bat"

echo Avvio del server di sviluppo Django...
python manage.py runserver

pause