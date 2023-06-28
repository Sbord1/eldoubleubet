Eldoubleubet è un sito di scommesse online in cui un utente può scommettere su vari sport.
In questo sito web è possibile scommettere su vari sport tra cui calcio, tennis, basket e ippica, tramite un menù che fa accedere alle sezioni apposite.
Il sito web gestisce una base dati in cui sono presenti le varie scommesse con le relative quote e una tabella di utenti con i relativi ruoli.

-----------------------------------------------------------------------------------------------------------------------------------
Tecniche impiegate

- Definizione di una DTD e di uno Schema per un documento XML

- Associazione di un documento XML ad una DTD / ad uno Schema

- Produzione di un documento XML tramite accesso ai dati in un database My SQL e creazione del documento tramite le funzionalità DOM per XML, disponibili in PHP.

- Presentazione di un documento XML tramite lettura dei dati in esso presenti attraverso le funzionalità DOM

- Verifica della correttezza della forma (well-formed) e della validità del documento XML sia relativamente alla DTD che allo schema tramite l'applicazione XML Copy Editor.

- Elementi block-level / in-line

- Utilizzo di CSS inline ed external + selettori CSS

- specifica colori #XXXXXX

- positioning: position, top, left, float, ...
-----------------------------------------------------------------------------------------------------------------------------------

Spiegazione tipologie di utenti e funzionalità

Esistono varie tipologie di utenti:

-	Visitatore: l’utente non registrato il quale può visitare il sito per invaghirsi ma non può effettuare nessun tipo di scommessa, a tal proposito può filtrare il palinsesto secondo le proprie preferenze di scommessa. Possono accedere a sezioni dove ci sono istruzioni generali su come effettuare una scommessa, inoltre sarà presente una sezione per registrarsi.

-	User: un semplice utente loggato che si sarà registrato in precedenza, questo potrà effettuare scommesse tramite una sezione apposita, visitare la sezione sulle informazioni generali riguardanti il sito e su come effettuare una scommessa, caricare il proprio conto virtuale (richiesta all’admin), consultare palinsesto e poterlo filtrare secondo le proprie preferenze, puntare su una determinata scommessa, accedere ad una sezione di riepilogo delle proprie scommesse ( una volta puntato non si può modificare ) e accedere ad un form in cui propone all’admin una scommessa.

- Gestore: utente con ruoli privilegiati, consultare il palinsesto e aggiungere nuove scommesse, consultare il form e decidere se aggiungere la scommessa proposta dall'user, può consultare la tabella utenti (per capire bilancio scommesse), eliminare scommesse relative ad eventi non svolti (viene eliminata la scommessa e tutte le puntate, che pero' rimangono nel sistema).

-	Admin: utente con ruoli privilegiati (ci sono solo 2 admin), non può effettuare scommesse ma ha le stesse funzionalità dell’user. Presenta tutti i privilegi del gestore e in più può decidere di approvare una ricarica del conto virtuale degli Users e disattivare alcuni utenti dalla tabella degli utenti.

-----------------------------------------------------------------------------------------------------------------------------------

Casi d’uso

Sul sito sono presenti varie sezioni che fanno riferimento ad un file .css per lo styling:

-	Sport: qui si può visualizzare le scommesse e le quote relative allo sport (ci possono essere diversi tipi di scommessa in base allo sport). C’è una       funzionalità che permette di filtrare le scommesse per (data di aggiunta, nome, quota).

-	Logging e registrazione: Un visitatore presenta la possibilità di loggarsi o di registrarsi. Un User e un Admin presentano la possibilità di fare log out.

-	Riepilogo: Sezione presente solo se si è User, qui è possibile controllare (ma non modificare) tutte le scommesse effettuate.

-	Carrello: Sezione presente solo se si è User, qui si effettua la puntata su tutte le scommesse selezionate.

-	Ricarica conto: Sezione presente solo se si è User, qui si fa richiesta all’admin per una ricarica del proprio conto virtuale.

-	Form: Sezione presente solo se si è User, qui si può richiedere all’Admin di aggiungere una determinata scommessa.

-	Accettazione conto: Sezione presente solo se si è Admin, qui si può accettare o rifiutare le richieste di ricarica del conto virtuale.

-	Tabella utenti: Sezione presente solo se si è Admin, qui si può controllare tutti gli utenti registrati nel database, e i relativi attributi tra cui il bilancio. è possibile disattivare gli account degli User.

-	Inserimento scommessa: Sezione presente solo se si è Admin, qui si può decidere di aggiungere una determinata scommessa che sarà poi presente nel palinsesto, inoltre tutte le richieste effettuate tramite form appariranno qui.

-	Forum: Sezione in cui è possibile scambiare messaggi tra utenti.

- Informazioni generali: Sezione in cui è possibile consultare delle informazioni generali su come funziona il sito e su come poter scommettere.
-----------------------------------------------------------------------------------------------------------------------------------

Strutture dati

- Tabella utenti: ogni utente presenta 6 attributi: nome, cognome, data di nascita (per verificare che sia maggiorenne), username, password e tipologia (user, gestore, admin).

- utenti.xml: Viene eseguito uno script (utenti.php?) che si collega al database e crea questo file xml, in cui è presentata la struttura dati degli utenti. La grammatica associata è definita dal file "utenti.dtd".

- sport.xml: Viene eseguito uno script (sport.php?) che si collega al database e crea questo file xml, in cui è presentata la struttura dati dello sport. La grammatica assiociata è definita dal file “sport.dtd”.

Un esempio di 3 scommesse di calcio, 3 di basket e 3 di tennis sono presenti nel file sport.xml
Un esempio di 2 utenti "admin", 2 utenti "user" e 2 utenti "gestore" sono presenti nel file utenti.xml
