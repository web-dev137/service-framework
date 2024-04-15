create table post
(
    id         int auto_increment
        primary key,
    post  varchar(250)  not null,
    created_at timestamp default CURRENT_TIMESTAMP  not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;