# ricette/forms.py

from django import forms
from .models import Libro

class LibroForm(forms.ModelForm):
    class Meta:
        model = Libro  # Specifica quale modello usare
        fields = ['codISBN', 'titolo', 'anno'] # I campi che vogliamo nel form

        # Aggiungiamo etichette in italiano (opzionale ma consigliato)
        labels = {
            'codISBN': 'Codice ISBN',
            'titolo': 'Titolo del Libro',
            'anno': 'Anno di Pubblicazione',
        }

        # Aggiungiamo attributi HTML per lo stile (es. classi CSS)
        widgets = {
            'codISBN': forms.TextInput(attrs={'required': True}),
            'titolo': forms.TextInput(attrs={'required': True}),
            'anno': forms.NumberInput(attrs={'required': True, 'min': 1000, 'max': 2099}),
        }