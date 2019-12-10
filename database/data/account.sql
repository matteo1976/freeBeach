-- Accounts for demo/test

insert into account (id_account, id_cliente, id_profilo, email, password, nome, indirizzo, telefono, abilitato)
values	(-1, null, 1, 'amministratore@bs.local', 'password', 'Amministratore Demo', 'Viale Roma, 1', '0123456789', 1),
	(-2, null, 2, 'operatore1@bs.local', 'password', 'Operatore Demo #1', 'Viale Roma, 1', '0123456789', 1),
	(-3, null, 2, 'operatore2@bs.local', 'password', 'Operatore Demo #2', 'Viale Roma, 1', '0123456789', 1);

insert into account (id_account, id_cliente, id_profilo, email, password, nome, indirizzo, telefono, abilitato)
values	(-4, -4, 3, 'cliente1@bs.local', 'password', 'Cliente Demo #1', 'Viale Roma, 1', '0123456789', 1),
	(-5, -5, 3, 'cliente2@bs.local', 'password', 'Cliente Demo #2', 'Viale Roma, 1', '0123456789', 1),
	(-6, -6, 3, 'cliente3@bs.local', 'password', 'Cliente Demo #3', 'Viale Roma, 1', '0123456789', 1),
	(-7, -7, 3, 'cliente4@bs.local', 'password', 'Cliente Demo #4', 'Viale Roma, 1', '0123456789', 1),
	(-8, -8, 3, 'cliente5@bs.local', 'password', 'Cliente Demo #5', 'Viale Roma, 1', '0123456789', 1);

