# ricette/forms.py

from django import forms
# Assicurati di importare tutti i modelli necessari
from .models import Libro, Regione, Ricetta 

# Form per la CREAZIONE e MODIFICA di un Libro
class LibroForm(forms.ModelForm):
    class Meta:
        model = Libro
        fields = ['codISBN', 'titolo', 'anno']
        labels = {
            'codISBN': 'Codice ISBN',
            'titolo': 'Titolo del Libro',
            'anno': 'Anno di Pubblicazione',
        }
        widgets = {
            'codISBN': forms.TextInput(attrs={'required': True, 'class': 'form-control'}),
            'titolo': forms.TextInput(attrs={'required': True, 'class': 'form-control'}),
            'anno': forms.NumberInput(attrs={'required': True, 'min': 1000, 'max': 2099, 'class': 'form-control'}),
        }

# --------------------------------------------------------------------

# Form per FILTRARE l'elenco delle Ricette (aggiungi questo!)
class RicettaFilterForm(forms.Form):
    filtro_nome = forms.CharField(
        required=False, 
        widget=forms.TextInput(attrs={'class': 'form-control', 'placeholder': 'Nome Ricetta'})
    )

    CATEGORIE_CHOICES = [
        ('', 'Tutte'),
        ('antipasto', 'Antipasto'),
        ('primo', 'Primo'),
        ('secondo', 'Secondo'),
        ('contorno', 'Contorno'),
        ('dessert', 'Dessert'),
    ]
    filtro_categoria = forms.ChoiceField(
        choices=CATEGORIE_CHOICES, 
        required=False,
        widget=forms.Select(attrs={'class': 'form-select'})
    )

    filtro_regione = forms.ModelChoiceField(
        queryset=Regione.objects.all().order_by('nome'),
        empty_label="Tutte",
        required=False,
        widget=forms.Select(attrs={'class': 'form-select'})
    )
    
    filtro_libro = forms.ModelChoiceField(
        queryset=Libro.objects.all().order_by('titolo'),
        empty_label="Tutti",
        required=False,
        widget=forms.Select(attrs={'class': 'form-select'})
    )