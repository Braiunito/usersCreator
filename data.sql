--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.10
-- Dumped by pg_dump version 9.6.10

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: _users; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._users (
    id smallint,
    firstname character varying(6) DEFAULT NULL::character varying,
    lastname character varying(7) DEFAULT NULL::character varying,
    pass character varying(60) DEFAULT NULL::character varying,
    email character varying(22) DEFAULT NULL::character varying,
    reg_date character varying(19) DEFAULT NULL::character varying
);


ALTER TABLE public._users OWNER TO rebasedata;

--
-- Data for Name: _users; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._users (id, firstname, lastname, pass, email, reg_date) FROM stdin;
1	Braian	Maciel	$2y$10$tR1ns0.5xV9k7AELV4jl9.H0ETnQevLounH8H2E3Y39etzgXjdhZS	braiantablet@gmail.com	2020-11-03 16:28:11
3	Briain	42 Mate	$2y$10$fLOiW.HCiVqvToOdOoQ8PeyY5Yai/F/BdvjkZ/jQow6GNWBj4RGKa	braian@42mate.com	2020-11-03 16:16:20
\.


--
-- PostgreSQL database dump complete
--

