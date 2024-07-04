create table chatbot
(
    id              int auto_increment
        primary key,
    keyword         text not null,
    chatbotresponse text not null
);

create table newsletter
(
    id      int auto_increment
        primary key,
    date    date         not null,
    type    varchar(255) not null,
    content text         not null,
    author  varchar(255) not null
);

create table user
(
    id                 int auto_increment
        primary key,
    pseudo             varchar(25)                  not null,
    firstname          varchar(30)                  not null,
    lastname           varchar(30)                  not null,
    email              varchar(255)                 not null,
    phone_number       varchar(15)                  null,
    extension          varchar(4)                   null,
    password           varchar(256)                 not null,
    country            varchar(2)                   null,
    grade              int                          not null,
    address            varchar(255)                 null,
    city               varchar(255)                 null,
    postal_code        varchar(5)                   null,
    creation_date      datetime   default curdate() not null,
    update_date        datetime                     null,
    is_deleted         tinyint(1) default 0         not null,
    is_admin           tinyint(1) default 0         not null,
    vip_status         tinyint(1) default 0         not null,
    delete_date        datetime                     null,
    vip_date           datetime                     null,
    is_validated       tinyint    default 0         not null,
    token              varchar(64)                  null,
    admin_comments     text                         null,
    pwd_token          varchar(64)                  null,
    sub_id             varchar(255)                 null,
    vip_type           int                          null,
    free_perf          int        default 0         not null,
    free_perf_end_date date                         null
);

create table housing
(
    id                int auto_increment
        primary key,
    id_user           int                                    null,
    address           varchar(255)                           not null,
    city              varchar(255)                           not null,
    country           varchar(255)                           not null,
    postal_code       int(5)                                 not null,
    title             varchar(255)                           not null,
    type_house        varchar(255)                           null,
    type_location     varchar(255)                           not null,
    amount_room       int                                    null,
    guest_capacity    int                                    not null,
    property_area     int                                    null,
    disponibility     datetime                               null,
    contact_phone     varchar(10)                            null,
    rate              text                                   null,
    price             decimal(10, 2)                         null,
    fee               decimal(10, 2)                         null,
    is_validated      tinyint(1) default 0                   null,
    creation_date     datetime   default current_timestamp() not null,
    is_deleted        tinyint    default 0                   not null,
    management_type   varchar(255)                           not null,
    contact_time      varchar(255)                           null,
    description       text                                   null,
    wifi              int        default 0                   not null,
    parking           int        default 0                   not null,
    pool              int        default 0                   not null,
    tele              int        default 0                   not null,
    oven              int        default 0                   not null,
    air_conditionning int        default 0                   not null,
    wash_machine      int                                    not null,
    gym               int        default 0                   not null,
    kitchen           int        default 0                   not null,
    constraint housing_ibfk_1
        foreign key (id_user) references user (id)
);

create index id_user
    on housing (id_user);

create table payment_method
(
    id      int auto_increment
        primary key,
    id_user int            null,
    type    int            not null,
    content char(16)       not null,
    amount  decimal(10, 2) not null,
    constraint payment_method_ibfk_1
        foreign key (id_user) references user (id)
);

create index id_user
    on payment_method (id_user);

create table performances
(
    id                  int auto_increment
        primary key,
    performance_type    varchar(50)                            not null,
    title               varchar(255)                           not null,
    description         text                                   not null,
    price_type          varchar(255)                           not null,
    price               decimal(10, 2)                         not null,
    fee                 decimal(10, 2)                         not null,
    zip_appointment     char(5)                                not null,
    address_appointment varchar(255)                           not null,
    city_appointment    varchar(255)                           not null,
    country_appointment varchar(255)                           not null,
    is_validated        tinyint(1) default 0                   not null,
    id_user             int                                    not null,
    is_deleted          tinyint    default 0                   not null,
    rate                int                                    null,
    place               varchar(255)                           null,
    radius              decimal(11, 8)                         null,
    creation_date       datetime   default current_timestamp() null,
    constraint user_id
        foreign key (id_user) references user (id)
);

create table booking
(
    id             int auto_increment
        primary key,
    user_id        int                         not null,
    start_date     datetime                    not null,
    end_date       datetime                    not null,
    price          double                      not null,
    amount_people  int       default 1         not null,
    housing_id     int                         null,
    performance_id int                         null,
    title          varchar(255)                not null,
    timestamp      timestamp default curtime() not null,
    review         varchar(255)                null,
    rate           int                         null,
    constraint booking_housing_id_fk
        foreign key (housing_id) references housing (id),
    constraint booking_ibfk_1
        foreign key (user_id) references user (id),
    constraint booking_performances_id_fk
        foreign key (performance_id) references performances (id)
);

create index user_id
    on booking (user_id);

create table disponibility
(
    ID             int auto_increment
        primary key,
    id_housing     int                      null,
    id_performance int                      null,
    date           date                     not null,
    hour_start     datetime                 null,
    hour_end       datetime                 null,
    is_booked      varchar(255) default '0' not null,
    hour_duration  varchar(255)             null,
    original_dispo int                      null,
    constraint disponibility_ibfk_1
        foreign key (id_housing) references housing (id),
    constraint disponibility_ibfk_2
        foreign key (id_performance) references performances (id)
);

create index id_housing
    on disponibility (id_housing);

create index id_performance
    on disponibility (id_performance);

create table likes
(
    id             int auto_increment
        primary key,
    id_user        int null,
    id_performance int null,
    id_housing     int null,
    constraint id_housing
        foreign key (id_housing) references housing (id),
    constraint id_performance
        foreign key (id_performance) references performances (id),
    constraint id_user
        foreign key (id_user) references user (id)
);

create table private_message
(
    id             int(111) auto_increment
        primary key,
    content        text                                   null,
    from_user_id   int                                    null,
    to_user_id     int                                    null,
    message_date   timestamp  default current_timestamp() not null,
    read_by_user   tinyint(1) default 0                   null,
    housing_id     int                                    null,
    performance_id int                                    null,
    id_conv        varchar(64)                            not null,
    constraint housing_id
        foreign key (housing_id) references housing (id),
    constraint private_message_ibfk_1
        foreign key (from_user_id) references user (id),
    constraint private_message_ibfk_2
        foreign key (to_user_id) references user (id),
    constraint private_message_performances_id_fk
        foreign key (performance_id) references performances (id)
);

create index from_user_id
    on private_message (from_user_id);

create index to_user_id
    on private_message (to_user_id);

create table ticket
(
    id            int auto_increment
        primary key,
    id_user       int                                   null,
    type          tinyint(1)                            not null,
    content       text                                  not null,
    creation_date timestamp default current_timestamp() not null,
    status        int       default 0                   not null,
    subject       int                                   not null,
    answer_id     int                                   null,
    tech_id       int                                   null,
    constraint ticket_ibfk_1
        foreign key (id_user) references user (id),
    constraint ticket_user_id_fk
        foreign key (tech_id) references user (id)
);

create index id_user
    on ticket (id_user);

