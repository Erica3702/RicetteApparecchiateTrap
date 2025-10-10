from django.shortcuts import render, redirect, get_object_or_404
from .models import Ricetta, Ingrediente, Regione, Pagina, Libro
from .forms import LibroForm
from django.contrib import messages


def home_view(request):
    """
    Mostra la pagina principale del sito con le statistiche.
    """
    # query per contare gli elementi nel database
    numero_ricette = Ricetta.objects.count()
    numero_libri = Libro.objects.count()
    numero_ingredienti = Ingrediente.objects.count()
    # numero_regioni = Regione.objects.count() 

    context = {
        'numero_ricette': numero_ricette,
        'numero_libri': numero_libri,
        'numero_ingredienti': numero_ingredienti,
    } 
    return render(request, 'ricette/home.html', context)


# VIEW PER L'ELENCO COMPLETO DELLE RICETTE
def elenco_ricette_view(request):
    """
    Mostra l'elenco di tutte le ricette, con la possibilità di filtrarle
    per nome, regione, tipo e libro.
    """
    # 1. Recupera i valori di tutti i filtri dalla richiesta GET
    nome_selezionato = request.GET.get('nome', '')
    regione_selezionata = request.GET.get('regione', '')
    tipo_selezionato = request.GET.get('tipo', '')
    libro_selezionato = request.GET.get('libro', '')

    # 2. Inizia con la query di base che prende tutte le ricette
    # .distinct() per evitare duplicati se una ricetta appare in più regioni/libri filtrati
    lista_ricette = Ricetta.objects.all().order_by('titolo').distinct()

    # 3. Applica i filtri uno dopo l'altro se sono stati specificati
    if nome_selezionato:
        # Filtra per nome della ricetta (case-insensitive)
        lista_ricette = lista_ricette.filter(titolo__icontains=nome_selezionato)

    if regione_selezionata:
        # Filtra per regione, attraversando la tabella intermedia
        lista_ricette = lista_ricette.filter(ricettaregionale__regione__cod=regione_selezionata)

    if tipo_selezionato:
        # Filtra per tipo di piatto
        lista_ricette = lista_ricette.filter(tipo=tipo_selezionato)

    if libro_selezionato:
        # Filtra per libro, attraversando la tabella intermedia RicettaPubblicata
         lista_ricette = lista_ricette.filter(pubblicata_in__libro__codISBN=libro_selezionato)   
    # 4. Prepara il context completo per il template
    context = {
        'lista_ricette': lista_ricette,
        'tutte_le_regioni': Regione.objects.all().order_by('nome'),
        'tutti_i_libri': Libro.objects.all().order_by('titolo'),
        'tipi_disponibili': ['antipasto', 'primo', 'secondo', 'contorno', 'dessert'],
        
        #valori selezionati per pre-compilare il form
        'nome_selezionato': nome_selezionato,
        'regione_selezionata': regione_selezionata,
        'tipo_selezionato': tipo_selezionato,
        'libro_selezionato': libro_selezionato,
    }

    return render(request, 'ricette/elenco_ricette.html', context)


# VIEW PER IL DETTAGLIO DI UNA SINGOLA RICETTA
def dettaglio_ricetta_view(request, numero_ricetta):
    # 1. Recupera la ricetta usando il suo 'numero' (la chiave primaria)
    ricetta = get_object_or_404(Ricetta, numero=numero_ricetta)
    
    # 2. Recupera tutti gli oggetti 'Ingrediente' che sono collegati a questa ricetta.
   
    ingredienti_della_ricetta = Ingrediente.objects.filter(ricetta=ricetta)

    # 3. Passa entrambi al context del template
    context = {
        'ricetta': ricetta,
        'ingredienti': ingredienti_della_ricetta,
    }
    
    return render(request, 'ricette/dettaglio_ricetta.html', context)


def crea_libro_view(request):
    if request.method == 'POST':
        # Se il form è stato inviato, elaboriamo i dati
        form = LibroForm(request.POST)
        if form.is_valid():
            form.save() # Salva il nuovo libro nel database
            messages.success(request, f'Il libro è stato creato con successo!')
            return redirect('home') 
    else:
        # Se è la prima visita (GET), mostra un form vuoto
        form = LibroForm()

    context = {
        'form': form
    }
    return render(request, 'ricette/crea_libro.html', context)

# VIEW PER L'ELENCO DEI LIBRI
def elenco_libri_view(request):
    tutti_i_libri = Libro.objects.all().order_by('titolo') # Ordina i libri per titolo
    context = {
        'lista_libri': tutti_i_libri
    }
    return render(request, 'ricette/elenco_libri.html', context)

def modifica_libro_view(request, codISBN):
    libro = get_object_or_404(Libro, pk=codISBN) # Trova il libro o restituisce errore 404
    
    if request.method == 'POST':
        form = LibroForm(request.POST, instance=libro) # Popola il form con i dati inviati e l'istanza esistente
        if form.is_valid():
            form.save()
            messages.success(request, f'Il libro "{libro.titolo}" è stato aggiornato con successo!')
            return redirect('elenco-libri') # Torna all'elenco dopo aver salvato
    else:
        form = LibroForm(instance=libro) # Mostra il form pre-compilato con i dati del libro

    context = {
        'form': form,
        'libro': libro
    }
    return render(request, 'ricette/modifica_libro.html', context)



# VIEW PER ELIMINARE UN LIBRO
def elimina_libro_view(request, codISBN):
    libro = get_object_or_404(Libro, pk=codISBN)
    if request.method == 'POST': # Per sicurezza, elimina solo tramite POST
        libro.delete()
        messages.success(request, f'Il libro "{libro.titolo}" è stato eliminato con successo.')
        return redirect('elenco-libri')
    
    # Se la richiesta non è POST, mostriamo una pagina di conferma
    context = {'libro': libro}
    return render(request, 'ricette/elimina_libro_conferma.html', context)


