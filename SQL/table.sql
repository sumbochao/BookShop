/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     10/11/2019 8:45:51 PM                        */
/*==============================================================*/


alter table DANH_GIA 
   drop foreign key FK_DANH_GIA_SACH;

alter table DANH_GIA 
   drop foreign key FK_DANH_GIA_KHACH_HANG;

alter table HOA_DON 
   drop foreign key FK_HOA_DON_SACH;

alter table HOA_DON 
   drop foreign key FK_HOA_DON_KHACH_HANG;

alter table HOA_DON 
   drop foreign key FK_HOA_DON_NHAN_VIEN;

alter table CHI_TIET_HOA_DON 
   drop foreign key FK_CHI_TIET_HOA_DON_HOA_DON;

alter table CHI_TIET_HOA_DON 
   drop foreign key FK_CHI_TIET_HOA_DON_SACH;

alter table SACH 
   drop foreign key FK_SACH_NHA_XUAT_BAN;

alter table SACH 
   drop foreign key FK_SACH_THE_LOAI;

drop table if exists DANH_GIA;

drop table if exists HOA_DON;

drop table if exists KHACH_HANG;

drop table if exists NHAN_VIEN;

drop table if exists NHA_XUAT_BAN;

drop table if exists SACH;

drop table if exists TAC_GIA;

drop table if exists CHI_TIET_HOA_DON;

drop table if exists THE_LOAI;

/*==============================================================*/
/* Table: DANH_GIA                                              */
/*==============================================================*/
create table DANH_GIA
(
   ID             	int AUTO_INCREMENT not null  comment '',
   ID_P                 int not null  comment '',
   TAI_KHOAN            varchar(30) not null  comment '',
   S_MA                 varchar(6) not null  comment '',
   NOI_DUNG             varchar(1000) not null comment '',
   NGAY             	datetime not null comment '',
   primary key (ID)
);

/*==============================================================*/
/* Table: HOA_DON                                               */
/*==============================================================*/
create table HOA_DON
(
   HD_MA                varchar(6) not null  comment '',
   HD_NGAY              datetime not null  comment '',
   NV_MA                varchar(6) not null  comment '',
   KH_MA                varchar(9) not null  comment '',
   HD_TONGTIEN          float not null comment '',
   HD_TINHTRANG         bool not null comment '',
   primary key (HD_MA, HD_NGAY)
);

/*==============================================================*/
/* Table: CHI_TIET_HOA_DON                                      */
/*==============================================================*/
create table CHI_TIET_HOA_DON
(
   HD_MA                varchar(6) not null  comment '',
   S_MA                 varchar(6) not null  comment '',
   SOLUONG 		int not null comment ''
);

/*==============================================================*/
/* Table: KHACH_HANG                                            */
/*==============================================================*/
create table KHACH_HANG
(
   KH_MA                varchar(9) not null comment '',
   KH_TAIKHOAN          varchar(30) not null UNIQUE comment '',
   KH_MATKHAU         varchar(50) not null comment '',
   KH_TEN               varchar(30) not null comment '',
   KH_GIOITINH          varchar(4) not null comment '',
   KH_NAMSINH           date not null comment '',
   KH_SDT               varchar(10) not null comment '',
   primary key (KH_MA)
);

/*==============================================================*/
/* Table: NHAN_VIEN                                             */
/*==============================================================*/
create table NHAN_VIEN
(
   NV_MA                varchar(6) not null  comment '',
   NV_TAIKHOAN          varchar(30) not null UNIQUE comment '',
   NV_MATKHAU       	varchar(50) not null  comment '',
   NV_TEN               varchar(30) not null comment '',
   NV_DC                varchar(150) not null comment '',
   NV_GIOITINH          varchar(4) not null comment '',
   NV_NAMSINH           date not null comment '',
   NV_SDT               varchar(10) not null comment '',
   primary key (NV_MA)
);

/*==============================================================*/
/* Table: NHA_XUAT_BAN                                          */
/*==============================================================*/
create table NHA_XUAT_BAN
(
   NXB_MA               varchar(6) not null  comment '',
   NXB_TEN              varchar(50) not null comment '',
   NXB_DC               varchar(150) not null comment '',
   NXB_SDT              varchar(10) not null comment '',
   primary key (NXB_MA)
);

/*==============================================================*/
/* Table: SACH                                                  */
/*==============================================================*/
create table SACH
(
   S_MA                 varchar(6) not null comment '',
   S_TEN                varchar(150) not null comment '',
   S_TACGIA             varchar(150) not null comment '',
   NXB_MA               varchar(6) not null comment '',
   TL_MA                varchar(6) not null comment '',
   S_MOTA               varchar(300) not null comment '',
   S_GIA                int not null comment '',
   S_SOLUONG            int not null comment '',
   S_ANH                varchar(150) not null comment '',
   primary key (S_MA)
);


/*==============================================================*/
/* Table: THE_LOAI                                              */
/*==============================================================*/
create table THE_LOAI
(
   TL_MA                varchar(6) not null  comment '',
   TL_TEN               varchar(50) not null comment '',
   primary key (TL_MA)
);

alter table DANH_GIA add constraint FK_DANH_GIA_SACH foreign key (S_MA)
      references SACH (S_MA) on delete cascade on update cascade;

alter table DANH_GIA add constraint FK_DANH_GIA_KHACH_HANG foreign key (KH_MA)
      references KHACH_HANG (KH_MA) on delete cascade on update cascade;

alter table HOA_DON add constraint FK_HOA_DON_KHACH_HANG foreign key (KH_MA)
      references KHACH_HANG (KH_MA) on delete cascade on update cascade;

alter table HOA_DON add constraint FK_HOA_DON_NHAN_VIEN foreign key (NV_MA)
      references NHAN_VIEN (NV_MA) on delete cascade on update cascade;

alter table CHI_TIET_HOA_DON add constraint FK_CHI_TIET_HOA_DON_HOA_DON foreign key (HD_MA)
      references HOA_DON (HD_MA) on delete cascade on update cascade;

alter table CHI_TIET_HOA_DON add constraint FK_CHI_TIET_HOA_DON_SACH foreign key (S_MA)
      references SACH (S_MA) on delete cascade on update cascade;

alter table SACH add constraint FK_SACH_NHA_XUAT_BAN foreign key (NXB_MA)
      references NHA_XUAT_BAN (NXB_MA) on delete cascade on update cascade;

alter table SACH add constraint FK_SACH_THE_LOAI foreign key (TL_MA)
      references THE_LOAI (TL_MA) on delete cascade on update cascade;

