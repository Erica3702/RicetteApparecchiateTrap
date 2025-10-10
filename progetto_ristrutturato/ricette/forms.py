from django import forms
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

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        # rende il campo non editabile nella pagina di modifica.
        if self.instance and self.instance.pk:
            self.fields['codISBN'].disabled = True

    def clean_codISBN(self):
        """
        Metodo di validazione che gestisce correttamente sia la creazione che la modifica.
        """
        # Recupera il codice ISBN dai dati del form
        codice = self.cleaned_data.get('codISBN')
        
        # Costruisce la query base per cercare duplicati
        queryset = Libro.objects.filter(codISBN=codice)
        
        # SE STIAMO MODIFICANDO, escludiamo il libro corrente dal controllo
        if self.instance and self.instance.pk:
            queryset = queryset.exclude(pk=self.instance.pk)
        
        # Se, dopo aver escluso il libro corrente, la query trova ancora qualcosa,
        # significa che un altro libro ha lo stesso ISBN.
        if queryset.exists():
            raise forms.ValidationError("Attenzione: un altro libro è già registrato con questo codice ISBN.")
            
        return codice
    

# Form per FILTRARE l'elenco delle Ricette
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