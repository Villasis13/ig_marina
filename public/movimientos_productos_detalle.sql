-- auto-generated definition
create table movimientos_productos_detalle
(
    id_movimientos_productos_detalle       bigint unsigned auto_increment
        primary key,
    id_movimientos_productos               bigint unsigned not null,
    id_pro                                 bigint unsigned not null,
    movimientos_productos_detalle_cantidad varchar(255)    not null,
    movimientos_productos_detalle_estado   varchar(255)    not null,
    created_at                             timestamp       null,
    updated_at                             timestamp       null,
    constraint movimientos_productos_detalle_id_movimientos_productos_foreign
        foreign key (id_movimientos_productos) references movimientos_productos (id_movimientos_productos),
    constraint movimientos_productos_detalle_id_producto_foreign
        foreign key (id_pro) references producto (id_producto)
);

