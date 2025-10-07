import csv
from django.core.management.base import BaseCommand
from django.db import transaction
from ricette.models import Regione, Libro, Pagina, Ricetta, Ingrediente, RicettaRegionale, RicettaPubblicata

class Command(BaseCommand):
    help = 'Popola l\'intero database con i dati dai file CSV'

    @transaction.atomic # Per garantire che o tutto funziona, o nulla viene salvato
    def handle(self, *args, **kwargs):
        self.stdout.write("Inizio popolamento completo del database...")
        
        # --- SVUOTIAMO LE TABELLE IN ORDINE INVERSO PER EVITARE ERRORI ---
        self.stdout.write("Svuotamento delle tabelle esistenti...")
        Ingrediente.objects.all().delete()
        RicettaRegionale.objects.all().delete()
        RicettaPubblicata.objects.all().delete()
        Pagina.objects.all().delete()
        Ricetta.objects.all().delete()
        Libro.objects.all().delete()
        Regione.objects.all().delete()
        self.stdout.write(self.style.SUCCESS("Tabelle svuotate."))

        # --- IMPORTIAMO LE TABELLE IN ORDINE DI DIPENDENZA ---

        # 1. Regioni (nessuna dipendenza)
        try:
            with open('regioni.csv', mode='r', encoding='utf-8-sig') as file:
                reader = csv.DictReader(file)
                for row in reader:
                    Regione.objects.create(cod=row['cod'], nome=row['nome'])
            self.stdout.write(self.style.SUCCESS('Regioni importate.'))
        except FileNotFoundError:
            self.stdout.write(self.style.ERROR('ERRORE: File "regioni.csv" non trovato.'))

        # 2. Libri (nessuna dipendenza)
        try:
            with open('libri.csv', mode='r', encoding='utf-8-sig') as file:
                reader = csv.DictReader(file)
                for row in reader:
                    Libro.objects.create(codISBN=row['codISBN'], titolo=row['titolo'], anno=row['anno'])
            self.stdout.write(self.style.SUCCESS('Libri importati.'))
        except FileNotFoundError:
            self.stdout.write(self.style.ERROR('ERRORE: File "libri.csv" non trovato.'))

        # 3. Ricette (nessuna dipendenza diretta dai CSV)
        try:
            with open('ricetta.csv', mode='r', encoding='utf-8-sig') as file:
                reader = csv.DictReader(file)
                for row in reader:
                    # Rimuovi eventuali spazi extra dal campo 'tipo'
                    tipo_pulito = row['tipo'].strip().lower()
                    Ricetta.objects.create(numero=row['numero'], titolo=row['titolo'], tipo=tipo_pulito)
            self.stdout.write(self.style.SUCCESS('Ricette importate.'))
        except FileNotFoundError:
            self.stdout.write(self.style.ERROR('ERRORE: File "ricetta.csv" non trovato.'))

        # 4. Pagine (dipende da Libro)
        try:
            with open('pagina.csv', mode='r', encoding='utf-8-sig') as file:
                reader = csv.DictReader(file)
                for row in reader:
                    libro_obj = Libro.objects.get(codISBN=row['libro'])
                    Pagina.objects.create(libro=libro_obj, numeroPagina=row['numeroPagina'])
            self.stdout.write(self.style.SUCCESS('Pagine importate.'))
        except FileNotFoundError:
            self.stdout.write(self.style.ERROR('ERRORE: File "pagina.csv" non trovato.'))

        # 5. Ingredienti (dipende da Ricetta)
        try:
            with open('ingrediente.csv', mode='r', encoding='utf-8-sig') as file:
                reader = csv.DictReader(file)
                for row in reader:
                    ricetta_obj = Ricetta.objects.get(pk=row['numeroRicetta'])
                    Ingrediente.objects.create(ricetta=ricetta_obj, numero=row['numero'], ingrediente=row['ingrediente'], quantità=row['quantità'])
            self.stdout.write(self.style.SUCCESS('Ingredienti importati.'))
        except FileNotFoundError:
            self.stdout.write(self.style.ERROR('ERRORE: File "ingrediente.csv" non trovato.'))
            
        # 6. RicettaRegionale (dipende da Regione e Ricetta)
        try:
            with open('ricettaRegionale.csv', mode='r', encoding='utf-8-sig') as file:
                reader = csv.DictReader(file)
                for row in reader:
                    regione_obj = Regione.objects.get(pk=row['regione'])
                    ricetta_obj = Ricetta.objects.get(pk=row['ricetta'])
                    RicettaRegionale.objects.create(regione=regione_obj, ricetta=ricetta_obj)
            self.stdout.write(self.style.SUCCESS('Relazioni Ricetta-Regione importate.'))
        except FileNotFoundError:
            self.stdout.write(self.style.ERROR('ERRORE: File "ricettaRegionale.csv" non trovato.'))

        # 7. RicettaPubblicata (dipende da Ricetta e Pagina)
        try:
            with open('ricettaPubblicata.csv', mode='r', encoding='utf-8-sig') as file:
                reader = csv.DictReader(file)
                for row in reader:
                    ricetta_obj = Ricetta.objects.get(pk=row['numeroRicetta'])
                    pagina_obj = Pagina.objects.get(libro__codISBN=row['libro'], numeroPagina=row['numeroPagina'])
                    RicettaPubblicata.objects.create(ricetta=ricetta_obj, pagina=pagina_obj)
            self.stdout.write(self.style.SUCCESS('Relazioni Ricetta-Pagina importate.'))
        except FileNotFoundError:
            self.stdout.write(self.style.ERROR('ERRORE: File "ricettaPubblicata.csv" non trovato.'))

        self.stdout.write(self.style.SUCCESS('Popolamento del database completato!'))