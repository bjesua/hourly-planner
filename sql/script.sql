create table if not exists horario
(
  id   int auto_increment
    primary key,
  hora time null
)
  comment 'set de horarios';

create table if not exists usuario
(
  id     int auto_increment
    primary key,
  nombre varchar(45) null
);

create table if not exists usuario_horario
(
  id             int(4) auto_increment
    primary key,
  id_hora_inicio int not null,
  id_hora_fin    int not null,
  usuario_id     int not null
);


