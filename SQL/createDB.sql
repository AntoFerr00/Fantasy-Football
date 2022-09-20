DROP TABLE IF EXISTS UTENTE cascade;
DROP TABLE IF EXISTS SQUADRA cascade;
DROP TABLE IF EXISTS PARTITA cascade;
DROP TABLE IF EXISTS PARTECIPAZIONE cascade;
DROP TABLE IF EXISTS GIOCATORE cascade;
DROP TABLE IF EXISTS FORMAZIONE cascade;
DROP TABLE IF EXISTS TIPO_FORMAZIONE cascade;
DROP TABLE IF EXISTS APPARTENENZA cascade;
DROP TABLE IF EXISTS PUNTEGGIO_GIOCATORE cascade;


CREATE TABLE SQUADRA(
	idSquadra serial PRIMARY KEY,
	nome varchar(30) NOT NULL,
	logo bytea NOT NULL
);

CREATE TABLE GIOCATORE(
	idGiocatore serial PRIMARY KEY,
	nome varchar(30) NOT NULL,
	cognome varchar(30) NOT NULL,
	numeroMaglia integer NOT NULL check(numeroMaglia > 0 AND numeroMaglia < 100) UNIQUE,
	squadraReale varchar(30) NOT NULL,
	ruolo varchar(30) NOT NULL,
	idPunteggioGiocatore serial NOT NULL
);

CREATE TABLE TIPO_FORMAZIONE(
	idTipoFormazione serial PRIMARY KEY,
	nomeFormazione VARCHAR(30) NOT NULL
);

CREATE TABLE PUNTEGGIO_GIOCATORE(
	idPunteggioGiocatore serial PRIMARY KEY,
	idPartita serial NOT NULL,
	punteggio integer NOT NULL check(punteggio > -1)
);

CREATE TABLE FORMAZIONE(
	idFormazione serial PRIMARY KEY,
	capitano varchar(30) NOT NULL,
	dataInserimento date NOT NULL,
	formazioneCorrente boolean NOT NULL,
	idSquadra serial NOT NULL , 
	idTipoFormazione INTEGER NOT NULL 
);

CREATE TABLE PARTITA(
	idPartita serial PRIMARY KEY,
	giornata integer NOT NULL,
	risultato varchar(30) NOT NULL,
	idSquadraCasa serial NOT NULL,
	idSquadraOspite serial NOT NULL
);

CREATE TABLE UTENTE(
	idUtente serial PRIMARY KEY,
	nome varchar(30) NOT NULL,
	password varchar(255) NOT NULL,
	email varchar(30) NOT NULL,
	idSquadra serial NOT NULL UNIQUE
);

CREATE TABLE APPARTENENZA(
	idAppartenenza serial PRIMARY KEY,
	idGiocatore serial NOT NULL,
	idFormazione serial NOT NULL
);

CREATE TABLE PARTECIPAZIONE(
	idPartecipazione serial PRIMARY KEY,
	Ruolo VARCHAR(30) NOT NULL,
	idSquadra serial NOT NULL, 
	idGiocatore serial NOT NULL
);

alter table GIOCATORE add constraint FK_GIOCATORE_PUNTEGGIOGIOCATORE foreign key(idPunteggioGiocatore) REFERENCES PUNTEGGIO_GIOCATORE(idPunteggioGiocatore) ON UPDATE CASCADE ON DELETE CASCADE;
alter table PUNTEGGIO_GIOCATORE add constraint FK_PUNTEGGIOGIOCATORE_PARTITA foreign key(idPartita) REFERENCES PARTITA(idPartita) ON UPDATE CASCADE ON DELETE CASCADE;
alter table SQUADRA add constraint FK_FORMAZIONE_SQUADRA foreign key(idSquadra) references SQUADRA(idSquadra) ON UPDATE CASCADE ON DELETE CASCADE;
alter table TIPO_FORMAZIONE add constraint FK_FORMAZIONE_TIPO_FORMAZIONE foreign key(idTipoFormazione) references TIPO_FORMAZIONE(idTipoFormazione) ON UPDATE CASCADE ON DELETE CASCADE;
alter table PARTITA add constraint FK_PARTITA_SQUADRA_CASA foreign key(idSquadraCasa) REFERENCES SQUADRA(idSquadra) ON UPDATE CASCADE ON DELETE CASCADE;
alter table PARTITA add constraint FK_PARTITA_SQUADRA_OSPITE foreign key(idSquadraOspite) REFERENCES SQUADRA(idSquadra) ON UPDATE CASCADE ON DELETE CASCADE;
alter table UTENTE add constraint FK_UTENTE_SQUADRA foreign key(idSquadra) REFERENCES SQUADRA(idSquadra) ON UPDATE CASCADE ON DELETE CASCADE;
alter table APPARTENENZA add constraint FK_APPARTENENZA_FORMAZIONE foreign key(idFormazione) REFERENCES FORMAZIONE(idFormazione) ON UPDATE CASCADE ON DELETE CASCADE;
alter table APPARTENENZA add constraint FK_APPARTENENZA_GIOCATORE foreign key(idGiocatore) REFERENCES GIOCATORE(idGiocatore) ON UPDATE CASCADE ON DELETE CASCADE;
alter table PARTECIPAZIONE add constraint FK_PARTECIPAZIONE_SQUADRA foreign key(idSquadra) references SQUADRA(idSquadra) ON UPDATE CASCADE ON DELETE CASCADE;
alter table PARTECIPAZIONE add constraint FK_PARTECIPAZIONE_GIOCATORE foreign key(idGiocatore) references GIOCATORE(idGiocatore) ON UPDATE CASCADE ON DELETE CASCADE;
