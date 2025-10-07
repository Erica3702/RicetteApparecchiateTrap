# mioprogetto/urls.py

from django.contrib import admin
from django.urls import path, include

urlpatterns = [
    path('admin/', admin.site.urls),
    
    # Collega il percorso principale del sito agli URL della nostra app 'ricette'
    path('', include('ricette.urls')),
]