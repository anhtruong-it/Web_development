drop table if exists vehicle;
create table vehicle(
    ids integer not null primary key autoincrement, 
    rego char(6) not null unique,
    model varchar(20) not null,
    years int not null,
    odometer varchar(6.1) default '0' not null
);

insert into vehicle values(null, "123ABC", "SUV", 2020, "123456");
insert into vehicle values(null, "JGI258", "SUV", 2016, "59432.3");
insert into vehicle values(null, "ODK794", "VAN", 2021, "985.1");
insert into vehicle values(null, "413OHC", "SUV", 2014, "976321");
insert into vehicle values(null, "998MMK", "Sedan", 2020, "96");
insert into vehicle values(null, "895THU", "Mini Bus", 2008, "746312.1");

drop table if exists client;
create table client(
    id integer not null primary key autoincrement,
    license char(9) not null,
    name varchar(20) not null,
    age int not null,
    licensetype varchar(100) not null
);

insert into client values(null, "123456789", "Tim", 19, "P1 (provisional, probationary or restricted licence)");
insert into client values(null, "123852643", "Bob", 30, "O (Open)");
insert into client values(null, "147023954", "Herry", 21, "P2 (provisional, probationary or restricted licence)");
insert into client values(null, "102458369", "Anh", 29, "L (Leaner)");

drop table if exists booking;
create table booking(
    id integer not null primary key autoincrement,
    vehicleId integer not null references vehicle(ids),
    clientId integer not null references client(id),
    datetimeH datetime not null,
    datetimeR datetime not null
);

insert into booking values(null, 1, 1, '2021-10-01T09:00', '2021-10-30T08:00');
insert into booking values(null, 2, 3, '2021-09-25T15:00', '2021-09-29T08:00');
insert into booking values(null, 1, 3, '2020-11-01T11:00', '2021-06-09T11:00');

drop table if exists duration;
create table duration(
    id integer not null primary key autoincrement,
    vehicleId integer not null references vehicle(ids),
    clientId integer not null references client(id),
    timess integer not null
    
);

insert into duration values(null, 1, 1, 2502000);
insert into duration values(null, 2, 3, 320400);
insert into duration values(null, 1, 3, 1900800);

