delete from subaffitti_postazione;
delete from disponibilita_postazione;
delete from assegnamenti_postazione;
delete from postazioni;

alter table assegnamenti_postazione auto_increment = 1;
alter table postazioni auto_increment = 1;

