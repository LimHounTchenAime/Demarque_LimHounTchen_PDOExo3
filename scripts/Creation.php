<?php
	header('Location: Insertion.php');
	use Factory\ConnectionFactory as Connection;
	Connection::setConfig();
	$bdd = Connection::connexion();

	$creer = $bdd->query('Select count(*) FROM information_schema.schemata WHERE SCHEMA_NAME = '.Connection::getDB());
	if(($data=$creer->fetch())!=1){
		$bdd->exec('Create Database '.Connection::getDB());
	}

	$sql = [];
	$q = $bdd->prepare('Select count(*) From information_schema.tables Where table_schema = ? table_name = ? LIMIT 1');
	$q->bindParam(1,Connection::getDB());
	$q->bindParam(2, 'agence');
	$q->execute();
	if(($data=$q->fetch())==1){
		array_push($sql,'create table agence  ('.
		'code_ag varchar(10), '.
		'nomresp varchar(30) not null, '.
		'numtel varchar(12) not null, '.
		'rue varchar(40), '.
		'ville varchar(25), '.
		'codpostal varchar(5), '.
		'pays  varchar(20), '.
		'primary key (code_ag))');
	}
	
	$q->bindParam(2, 'client');
	$q->execute();
	if(($data=$q->fetch())==1){
		array_push($sql,'create table client  ( '.
		'code_cli varchar(8), '.
		'nom  varchar(40) not null, '.
		'rue varchar(40) not null, '.
		'ville varchar(25) not null, '.
		'codpostal varchar(5) not null, '.
		'primary key (code_cli))');
	}

	$q->bindParam(2, 'categorie');
	$q->execute();
	if(($data=$q->fetch())==1){
		array_push($sql,'create table categorie  ( '.
		'code_categ varchar2(3), '.
		'libelle varchar2(30) not null, '.
		'nbpers number(2) not null, '.
		'type_permis varchar2(2) check(type_permis in ('a','a1','b','c','d','e_b','e_c','e_d')) not null, '.
		'code_tarif varchar2(3), '.
		'primary key (code_categ)) ');
	}

	$q->bindParam(2, 'tarif');
	$q->execute();
	if(($data=$q->fetch())==1){
		array_push($sql,'create table tarif  ( '.
		'code_tarif varchar2(3), '.
		'tarif_jour number(6,2) not null, '.
		'tarif_hebdo number(6,2) not null, '.
		'tarif_kil number(4,2) not null, '.
		'tarif_w500 number(6,2) not null, '.
		'tarif_w800 number(6,2) not null, '.
		'tarif_asur number(6,2) not null, '.
		'primary key (code_tarif))');
	}

	$q->bindParam(2, 'vehicule');
	$q->execute();
	if(($data=$q->fetch())==1){
		array_push($sql,'create table vehicule  ('.
	  	'no_imm varchar2(10), '.
	  	'marque varchar2(20) not null, '.
	  	'modele varchar2(20) not null, '.
	  	'couleur varchar2(20), '.
	  	'date_achat date check(to_char(date_achat,\'yyyy\')>1998), '.
	  	'kilometres number(6) check(kilometres>=0), '.
	 	'code_categ varchar2(3), '.
	  	'code_ag varchar2(10), '.
	 	'primary key (no_imm))');
	}

	$q->bindParam(2, 'calendrier');
	$q->execute();
	if(($data=$q->fetch())==1){
	 	array_push($sql,'create table calendrier '.
		'( no_imm varchar2(10), '.
		'datejour date, '.
		'paslibre char(1), '.
		'primary key (no_imm,datejour))');
	}

	$q->bindParam(2, 'dossier');
	$q->execute();
	if(($data=$q->fetch())==1){
		array_push($sql,'create table dossier  ( '.
		'no_dossier number(6), '.
		'date_retrait date not null, '.
		'date_retour date not null, '.
		'date_effect date, '.
		'kil_retrait number(6), '.
		'kil_retour number(6), '.
		'type_tarif varchar2(5), '.
		'assur char(1), '.
		'nbjour_fact number(3), '.
		'nbsem_fact number(3), '.
		'remise number(4,2), '.
		'code_cli varchar2(8), '.
		'no_imm varchar2(10), '.
		'ag_retrait varchar2(10), '.
		'ag_retour varchar2(10), '.
		'ag_reserve varchar2(10), '.
		'primary key (no_dossier))');
	}

	$q = $bdd->prepare('Select count(*) From information_schema.tables Where table_schema = ?');
	$q->bindParam(1,Connection::getDB());
	$q->execute();
	if($data=$q->fetch())==
	array_push($sql,'alter table dossier add (constraint fk_codecli foreign key (code_cli) references client(code_cli))');
	array_push($sql,'alter table dossier add(constraint fk_noimm foreign key (no_imm) references vehicule(no_imm))');
	array_push($sql,'alter table dossier add(constraint fk_agretrait foreign key (ag_retrait) references agence(code_ag))');
	array_push($sql,'alter table dossier add (constraint fk_agretour foreign key (ag_retour) references agence(code_ag))');
	array_push($sql,'alter table dossier add (constraint fk_agreserve foreign key (ag_reserve) references agence(code_ag))');
	array_push($sql,'alter table vehicule add (constraint fk_codecateg foreign key(code_categ) references categorie(code_categ))');
	array_push($sql,'alter table vehicule add (constraint fk_codeag foreign key(code_ag) references agence(code_ag))');
	array_push($sql,'alter table categorie add (constraint fk_codetarif foreign key(code_tarif) references tarif(code_tarif))');
	array_push($sql,'alter table calendrier add(constraint fk_noimm1 foreign key (no_imm) references vehicule(no_imm))');

	foreach ($sql as $key => $value) {
		$bdd->exec($value);
	}
?>