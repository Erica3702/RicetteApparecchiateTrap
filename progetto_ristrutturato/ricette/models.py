from django.db import models

class Regione(models.Model):
    cod = models.CharField(max_length=3, primary_key=True)
    nome = models.CharField(max_length=100)

    def __str__(self):
        return self.nome

class Libro(models.Model):
    codISBN = models.CharField(max_length=13, primary_key=True)
    titolo = models.CharField(max_length=200)
    anno = models.IntegerField()

    def __str__(self):
        return self.titolo

class Pagina(models.Model):
    libro = models.ForeignKey(Libro, on_delete=models.CASCADE)
    numeroPagina = models.IntegerField()

    class Meta:
        # Questo simula la chiave primaria composta del diagramma
        unique_together = ('libro', 'numeroPagina')

    def __str__(self):
        return f"{self.libro.titolo} - Pag. {self.numeroPagina}"

class Ricetta(models.Model):
    # Tipi di ricetta permessi, come da diagramma
    class TipoRicetta(models.TextChoices):
        ANTIPASTO = 'antipasto', 'Antipasto'
        PRIMO = 'primo', 'Primo'
        SECONDO = 'secondo', 'Secondo'
        CONTORNO = 'contorno', 'Contorno'
        DESSERT = 'dessert', 'Dessert'

    numero = models.IntegerField(primary_key=True) 
    titolo = models.CharField(max_length=200)
    tipo = models.CharField(max_length=10, choices=TipoRicetta.choices)
    
    # Relazioni Molti-a-Molti
    regioni = models.ManyToManyField(Regione, through='RicettaRegionale')
    pubblicata_in = models.ManyToManyField(Pagina, through='RicettaPubblicata')

    def __str__(self):
        return self.titolo

class Ingrediente(models.Model):
    ricetta = models.ForeignKey(Ricetta, on_delete=models.CASCADE, related_name='ingredienti')
    numero = models.IntegerField()
    ingrediente = models.CharField(max_length=100)
    quantità = models.CharField(max_length=50)

    class Meta:
        # 2. Ora il nome del campo è corretto
        unique_together = ('ricetta', 'numero')

    def __str__(self):
        return f"{self.ingrediente} ({self.quantità})"

# Tabelle "through" per le relazioni Molti-a-Molti
class RicettaRegionale(models.Model):
    regione = models.ForeignKey(Regione, on_delete=models.CASCADE)
    ricetta = models.ForeignKey(Ricetta, on_delete=models.CASCADE)

class RicettaPubblicata(models.Model):
    # Basta un solo ForeignKey a Pagina, che già contiene il libro e il numero
    pagina = models.ForeignKey(Pagina, on_delete=models.CASCADE)
    ricetta = models.ForeignKey(Ricetta, on_delete=models.CASCADE)