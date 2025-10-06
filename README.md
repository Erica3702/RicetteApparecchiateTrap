<img width="1888" height="810" alt="image" src="https://github.com/user-attachments/assets/f4b7cfa1-c052-4121-9131-46468b081ac2" />

## Progetto di programmazione web 2024/2025
Cattaneo Luca (1079489), Locatelli Erica (1081101)

link al sito: http://ricetteapparecchiate.altervista.org/

### 1. Introduzione
“Ricette apparecchiate” è un’applicazione web gestionale progettata per una casa editrice
specializzata in libri di cucina. Lo scopo del sistema è di fornire a un operatore interno uno
strumento efficiente e intuitivo per gestire l’intero catalogo di libri e l’archivio digitale delle
ricette. L’applicazione permette di consultare, aggiungere, modificare e eliminare
informazioni.
### 2. Interfaccia
La struttura è basata su un layout a due colonne principali, preceduto da un header a
schermo intero. La sidebar a sinistra contiene il menu di navigazione principale, strutturato
con sottomenu a tendina per raggruppare le funzionalità. Nelle pagine contestuali, si trova
anche il filtro di ricerca. Al centro troviamo l’area principale dove vengono visualizzati i
risultati di ricerca.
### 3. L’utente
L’applicazione è progettata per un profilo utente specifico: il gestore di catalogo della casa
editrice. È un utente professionale che ha familiarità con le operazioni di data-entry e la
gestione di archivi digitali.
### 4. Funzionalità e operazioni CRUD
L'applicazione implementa un sistema di gestione completo, con un focus particolare sulla
tabella Libro.

Operazioni CRUD su Libro:

● Create: Tramite la pagina crea_libro.php, l'utente può inserire un nuovo libro
nel database. È stato implementato un controllo lato server in salva_libro.php
per impedire l'inserimento di libri con un codice ISBN duplicato.

● Read: La pagina elenco_libri.php mostra l'elenco completo di tutti i libri
presenti nel catalogo, ordinati per titolo.

● Update: Dalla tabella dell'elenco, ogni libro ha un pulsante "Modifica" che
porta al form modifica_libro.php. Questo form viene pre-compilato con i dati
attuali del libro, permettendo all'utente di aggiornare titolo e anno.

● Delete: Ogni libro ha un pulsante "Elimina" che, previa conferma tramite un
pop-up, rimuove il record dal database.
Ricerca Avanzata Ricette:

● La pagina elenco_ricette.php permette una consultazione completa
dell'archivio ricette.

● Nella sidebar appare il filtro di ricerca (filtro_ricette.php) che permette di
raffinare la ricerca per nome, categoria (es. primo, dessert) e regione.

### 5. Sistema di Messaggistica (Who, When, What, Where, How)
È stato implementato un sistema di feedback per comunicare efficacemente con l'utente.

● A chi devo comunicare?

Al "Gestore del Catalogo".

● Quando devo avvertire l’utente?

Dopo un'azione completata con successo (creazione, modifica, eliminazione), prima
di un'azione distruttiva e irreversibile (eliminazione), quando viene commesso un
errore (es. inserimento di un duplicato).

● Cosa devo comunicargli?

Messaggi chiari e concisi.

● Dove?

I messaggi di successo/errore appaiono in cima all'area contenuti della pagina a cui
l'utente viene reindirizzato. I messaggi di conferma appaiono al centro dello schermo
come un pop-up.

● Come lo comunico?
- Successo: Banner verdi.
- Errore: Banner rossi.
- Conferma: Un pop-up.

### 6. Analisi delle Query SQL
L'applicazione si basa su query SQL sicure ed efficienti, utilizzando Prepared Statements
per prevenire attacchi di tipo SQL Injection.

### Query di Inserimento (Create):

INSERT INTO Libro (codISBN, titolo, anno) VALUES (?, ?, ?);

(Utilizza i placeholder ? per garantire la sicurezza dei dati inseriti dall'utente).

### Query di Controllo Duplicati:

SELECT codISBN FROM Libro WHERE codISBN = ?;

(Una query eseguita prima dell'inserimento per verificare l'unicità della chiave primaria).

### Query di Aggiornamento:

UPDATE Libro SET titolo = ?, anno = ? WHERE codISBN = ?;

(Modifica i campi specificati per il libro identificato tramite il suo ISBN).

### Query di Ricerca Ricette:

SELECT R.titolo, R.tipo, GROUP_CONCAT(RG.nome SEPARATOR ', ') AS regioni

FROM Ricetta R

LEFT JOIN ricettaRegionale RR ON R.numero = RR.ricetta

LEFT JOIN Regione RG ON RR.regione = RG.codice

WHERE ...

GROUP BY R.numero, R.titolo, R.tipo

ORDER BY R.titolo ASC;

(Utilizza LEFT JOIN per unire i dati di tre tabelle, mostrando anche le ricette non associate a
una regione. La funzione GROUP_CONCAT è usata per aggregare tutte le regioni di una
ricetta in una singola stringa, evitando righe duplicate nei risultati).
