

drop database if exists andrewfharriscom_appointmentdb;
create database if not exists andrewfharriscom_appointmentdb;
use andrewfharriscom_appointmentdb;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` nvarchar(255) NOT NULL,
  `password` char(60) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`username`)
);


create table operating_hours(
	operating_hours_id int unsigned not null auto_increment primary key,
    day_of_week enum('Sun','Mon','Tue','Wed','Thu','Fri','Sat') not null,
    open_time time,
    close_time time,
    date_created datetime default current_timestamp,
    last_updated timestamp
);

create table appointments(
	appointment_id int unsigned not null auto_increment primary key,
    user_id int unsigned not null,
    appointment_date date,
    appointment_time time,
    appointment_timestamp long,
    date_created datetime default current_timestamp,
    last_updated timestamp,
    constraint appointments_users_fk foreign key (user_id) 
        references users(id) on delete cascade 
);

insert into operating_hours(day_of_week, open_time, close_time)
values
	('Mon', '8:00', '16:00'),
	('Tue', '8:00', '16:00'),
	('Wed', '8:00', '16:00'),
    ('Thu', '8:00', '16:00'),
	('Fri', '8:00', '17:00');

#select day_of_week+0 from operating_hours; # returns 1 through 7 (enum numeric values)

#insert into appointments(appointment_date, appointment_time, appointment_timestamp)
#values (date(from_unixtime(1443686400)), time(from_unixtime(1443686400)), 1443686400);

#select * from appointments;
