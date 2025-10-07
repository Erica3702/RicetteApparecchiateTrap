from django.contrib import admin
from .models import Regione, Libro, Pagina, Ricetta, Ingrediente, RicettaRegionale, RicettaPubblicata

admin.site.register(Regione)
admin.site.register(Libro)
admin.site.register(Pagina)
admin.site.register(Ricetta)
admin.site.register(Ingrediente)
admin.site.register(RicettaRegionale)
admin.site.register(RicettaPubblicata)