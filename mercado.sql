PGDMP                         y            mercado    9.4.26     13.2 (Ubuntu 13.2-1.pgdg18.04+1) '    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    16384    mercado    DATABASE     \   CREATE DATABASE mercado WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE = 'pt_BR.UTF-8';
    DROP DATABASE mercado;
                postgres    false                        0    0    SCHEMA public    ACL     �   REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;
                   postgres    false    6            �            1259    16396    produto    TABLE     �   CREATE TABLE public.produto (
    id integer NOT NULL,
    nome character varying(250) NOT NULL,
    valor double precision NOT NULL,
    tpr_id integer NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);
    DROP TABLE public.produto;
       public            postgres    false            �            1259    16399    produto_pro_id_seq    SEQUENCE     {   CREATE SEQUENCE public.produto_pro_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.produto_pro_id_seq;
       public          postgres    false    173                       0    0    produto_pro_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE public.produto_pro_id_seq OWNED BY public.produto.id;
          public          postgres    false    174            �            1259    16409    tipo_produto    TABLE     �   CREATE TABLE public.tipo_produto (
    id integer NOT NULL,
    nome character varying(250) NOT NULL,
    percentual_imposto double precision NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);
     DROP TABLE public.tipo_produto;
       public            postgres    false            �            1259    16407    tipo_produto_tpr_id_seq    SEQUENCE     �   CREATE SEQUENCE public.tipo_produto_tpr_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.tipo_produto_tpr_id_seq;
       public          postgres    false    176                       0    0    tipo_produto_tpr_id_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE public.tipo_produto_tpr_id_seq OWNED BY public.tipo_produto.id;
          public          postgres    false    175            �            1259    16417    venda    TABLE       CREATE TABLE public.venda (
    id integer NOT NULL,
    nome character varying(150) NOT NULL,
    total double precision NOT NULL,
    total_imposto double precision NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);
    DROP TABLE public.venda;
       public            postgres    false            �            1259    16425    venda_produto    TABLE     ~  CREATE TABLE public.venda_produto (
    id integer NOT NULL,
    ven_id integer NOT NULL,
    pro_id integer NOT NULL,
    valor double precision NOT NULL,
    imposto double precision NOT NULL,
    quantidade double precision,
    total double precision,
    total_imposto double precision,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);
 !   DROP TABLE public.venda_produto;
       public            postgres    false            �            1259    16423    venda_produto_vpr_id_seq    SEQUENCE     �   CREATE SEQUENCE public.venda_produto_vpr_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE public.venda_produto_vpr_id_seq;
       public          postgres    false    180                       0    0    venda_produto_vpr_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE public.venda_produto_vpr_id_seq OWNED BY public.venda_produto.id;
          public          postgres    false    179            �            1259    16415    venda_ven_id_seq    SEQUENCE     y   CREATE SEQUENCE public.venda_ven_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.venda_ven_id_seq;
       public          postgres    false    178                       0    0    venda_ven_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.venda_ven_id_seq OWNED BY public.venda.id;
          public          postgres    false    177            s           2604    16401 
   produto id    DEFAULT     l   ALTER TABLE ONLY public.produto ALTER COLUMN id SET DEFAULT nextval('public.produto_pro_id_seq'::regclass);
 9   ALTER TABLE public.produto ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    174    173            t           2604    16412    tipo_produto id    DEFAULT     v   ALTER TABLE ONLY public.tipo_produto ALTER COLUMN id SET DEFAULT nextval('public.tipo_produto_tpr_id_seq'::regclass);
 >   ALTER TABLE public.tipo_produto ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    175    176    176            u           2604    16420    venda id    DEFAULT     h   ALTER TABLE ONLY public.venda ALTER COLUMN id SET DEFAULT nextval('public.venda_ven_id_seq'::regclass);
 7   ALTER TABLE public.venda ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    178    177    178            v           2604    16428    venda_produto id    DEFAULT     x   ALTER TABLE ONLY public.venda_produto ALTER COLUMN id SET DEFAULT nextval('public.venda_produto_vpr_id_seq'::regclass);
 ?   ALTER TABLE public.venda_produto ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    179    180    180            �          0    16396    produto 
   TABLE DATA           R   COPY public.produto (id, nome, valor, tpr_id, created_at, updated_at) FROM stdin;
    public          postgres    false    173   ,       �          0    16409    tipo_produto 
   TABLE DATA           \   COPY public.tipo_produto (id, nome, percentual_imposto, created_at, updated_at) FROM stdin;
    public          postgres    false    176   6,       �          0    16417    venda 
   TABLE DATA           W   COPY public.venda (id, nome, total, total_imposto, created_at, updated_at) FROM stdin;
    public          postgres    false    178   S,       �          0    16425    venda_produto 
   TABLE DATA           �   COPY public.venda_produto (id, ven_id, pro_id, valor, imposto, quantidade, total, total_imposto, created_at, updated_at) FROM stdin;
    public          postgres    false    180   p,                  0    0    produto_pro_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.produto_pro_id_seq', 18, true);
          public          postgres    false    174                       0    0    tipo_produto_tpr_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.tipo_produto_tpr_id_seq', 4, true);
          public          postgres    false    175                       0    0    venda_produto_vpr_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('public.venda_produto_vpr_id_seq', 44, true);
          public          postgres    false    179                       0    0    venda_ven_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.venda_ven_id_seq', 51, true);
          public          postgres    false    177            y           2606    16406    produto produto_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.produto
    ADD CONSTRAINT produto_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.produto DROP CONSTRAINT produto_pkey;
       public            postgres    false    173            {           2606    16414    tipo_produto tipo_produto_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.tipo_produto
    ADD CONSTRAINT tipo_produto_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.tipo_produto DROP CONSTRAINT tipo_produto_pkey;
       public            postgres    false    176            }           2606    16422    venda venda_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.venda
    ADD CONSTRAINT venda_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.venda DROP CONSTRAINT venda_pkey;
       public            postgres    false    178            �           2606    16430     venda_produto venda_produto_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.venda_produto
    ADD CONSTRAINT venda_produto_pkey PRIMARY KEY (id);
 J   ALTER TABLE ONLY public.venda_produto DROP CONSTRAINT venda_produto_pkey;
       public            postgres    false    180            ~           1259    16453 
   fki_pro_id    INDEX     F   CREATE INDEX fki_pro_id ON public.venda_produto USING btree (pro_id);
    DROP INDEX public.fki_pro_id;
       public            postgres    false    180            w           1259    16441 
   fki_tpr_id    INDEX     @   CREATE INDEX fki_tpr_id ON public.produto USING btree (tpr_id);
    DROP INDEX public.fki_tpr_id;
       public            postgres    false    173                       1259    16447 
   fki_ven_id    INDEX     F   CREATE INDEX fki_ven_id ON public.venda_produto USING btree (ven_id);
    DROP INDEX public.fki_ven_id;
       public            postgres    false    180            �           2606    16448    venda_produto pro_id    FK CONSTRAINT     ~   ALTER TABLE ONLY public.venda_produto
    ADD CONSTRAINT pro_id FOREIGN KEY (pro_id) REFERENCES public.produto(id) NOT VALID;
 >   ALTER TABLE ONLY public.venda_produto DROP CONSTRAINT pro_id;
       public          postgres    false    1913    173    180            �           2606    16436    produto tpr_id    FK CONSTRAINT     }   ALTER TABLE ONLY public.produto
    ADD CONSTRAINT tpr_id FOREIGN KEY (tpr_id) REFERENCES public.tipo_produto(id) NOT VALID;
 8   ALTER TABLE ONLY public.produto DROP CONSTRAINT tpr_id;
       public          postgres    false    1915    176    173            �           2606    16442    venda_produto ven_id    FK CONSTRAINT     |   ALTER TABLE ONLY public.venda_produto
    ADD CONSTRAINT ven_id FOREIGN KEY (ven_id) REFERENCES public.venda(id) NOT VALID;
 >   ALTER TABLE ONLY public.venda_produto DROP CONSTRAINT ven_id;
       public          postgres    false    180    1917    178            �      x������ � �      �      x������ � �      �      x������ � �      �      x������ � �     