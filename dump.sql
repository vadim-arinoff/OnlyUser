--
-- PostgreSQL database dump
--

-- Dumped from database version 17.4
-- Dumped by pg_dump version 17.4

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id integer NOT NULL,
    name character varying(30),
    phone character varying(16),
    email character varying(30),
    password_hash character varying,
    created_at timestamp without time zone DEFAULT now()
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, name, phone, email, password_hash, created_at) FROM stdin;
1	adfg asdf	999545554	wiwota1025@adambra.com	$2y$12$fQ37l0XMDRZNDQwFZYFlbe7beTyMLxxaULbyN6jmcLtNI8VSsgKMG	\N
2	adasdf	9995455545555555	wiwa125@adbra.com	$2y$12$FKR5ygm2RqvujDqyH7W7h.HuL5eXbjhVvqtkF2OWOQEYPOUuPmDS2	\N
5	asdeas	992245554	wiwa22125@adbra.com	$2y$12$qT3mQ8Ao1uAkoe9EZqEnBe6izxi.KhrpmD3ly5bNkf4AMQeJR4YAa	\N
6	vadya	9999558585	vadya@adbra.com	$2y$12$33zmgmswIlkjb/OOJVgQLOYsE6dkLL9U9qKnA6bll99KuH7RMb7Fa	2025-07-10 15:56:50.929652
7	vadya1	+79999999999	vadya@mail.com	$2y$12$mhjH3GzXiqD.0M2Nh4k9gefv4SiS.wTWUWgbW6Du5sn8c/ieXIuTe	2025-07-10 16:06:45.618394
\.


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 7, true);


--
-- Name: users users_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- Name: users users_phone_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_phone_key UNIQUE (phone);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- PostgreSQL database dump complete
--

