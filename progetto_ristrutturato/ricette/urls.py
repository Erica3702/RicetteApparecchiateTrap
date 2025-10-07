# ricette/urls.py

from django.urls import path
from . import views

urlpatterns = [
    # Rotta per la home page
    path('', views.home_view, name='home'),

    # Rotte per le Ricette
    path('ricette/', views.elenco_ricette_view, name='elenco-ricette'),
    path('ricette/<int:numero_ricetta>/', views.dettaglio_ricetta_view, name='dettaglio-ricetta'),

    # Rotte per i Libri
    path('libri/', views.elenco_libri_view, name='elenco-libri'),
    path('libri/nuovo/', views.crea_libro_view, name='crea-libro'),
    path('libri/modifica/<str:codISBN>/', views.modifica_libro_view, name='modifica-libro'),
    path('libri/elimina/<str:codISBN>/', views.elimina_libro_view, name='elimina-libro'),
]