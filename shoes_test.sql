--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: brands; Type: TABLE; Schema: public; Owner: masterNielson; Tablespace: 
--

CREATE TABLE brands (
    id integer NOT NULL,
    brand_name character varying
);


ALTER TABLE brands OWNER TO "masterNielson";

--
-- Name: brands_id_seq; Type: SEQUENCE; Schema: public; Owner: masterNielson
--

CREATE SEQUENCE brands_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE brands_id_seq OWNER TO "masterNielson";

--
-- Name: brands_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: masterNielson
--

ALTER SEQUENCE brands_id_seq OWNED BY brands.id;


--
-- Name: stores; Type: TABLE; Schema: public; Owner: masterNielson; Tablespace: 
--

CREATE TABLE stores (
    id integer NOT NULL,
    name character varying
);


ALTER TABLE stores OWNER TO "masterNielson";

--
-- Name: stores_brands; Type: TABLE; Schema: public; Owner: masterNielson; Tablespace: 
--

CREATE TABLE stores_brands (
    id integer NOT NULL,
    store_id integer,
    brand_id integer
);


ALTER TABLE stores_brands OWNER TO "masterNielson";

--
-- Name: stores_brands_id_seq; Type: SEQUENCE; Schema: public; Owner: masterNielson
--

CREATE SEQUENCE stores_brands_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE stores_brands_id_seq OWNER TO "masterNielson";

--
-- Name: stores_brands_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: masterNielson
--

ALTER SEQUENCE stores_brands_id_seq OWNED BY stores_brands.id;


--
-- Name: stores_id_seq; Type: SEQUENCE; Schema: public; Owner: masterNielson
--

CREATE SEQUENCE stores_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE stores_id_seq OWNER TO "masterNielson";

--
-- Name: stores_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: masterNielson
--

ALTER SEQUENCE stores_id_seq OWNED BY stores.id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: masterNielson
--

ALTER TABLE ONLY brands ALTER COLUMN id SET DEFAULT nextval('brands_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: masterNielson
--

ALTER TABLE ONLY stores ALTER COLUMN id SET DEFAULT nextval('stores_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: masterNielson
--

ALTER TABLE ONLY stores_brands ALTER COLUMN id SET DEFAULT nextval('stores_brands_id_seq'::regclass);


--
-- Data for Name: brands; Type: TABLE DATA; Schema: public; Owner: masterNielson
--

COPY brands (id, brand_name) FROM stdin;
\.


--
-- Name: brands_id_seq; Type: SEQUENCE SET; Schema: public; Owner: masterNielson
--

SELECT pg_catalog.setval('brands_id_seq', 70, true);


--
-- Data for Name: stores; Type: TABLE DATA; Schema: public; Owner: masterNielson
--

COPY stores (id, name) FROM stdin;
\.


--
-- Data for Name: stores_brands; Type: TABLE DATA; Schema: public; Owner: masterNielson
--

COPY stores_brands (id, store_id, brand_id) FROM stdin;
1	1	16
2	2	28
3	3	42
4	16	45
5	16	46
6	17	47
7	17	48
8	30	49
9	30	50
10	31	51
11	31	52
12	32	64
13	45	67
14	45	68
15	46	69
16	46	70
\.


--
-- Name: stores_brands_id_seq; Type: SEQUENCE SET; Schema: public; Owner: masterNielson
--

SELECT pg_catalog.setval('stores_brands_id_seq', 16, true);


--
-- Name: stores_id_seq; Type: SEQUENCE SET; Schema: public; Owner: masterNielson
--

SELECT pg_catalog.setval('stores_id_seq', 46, true);


--
-- Name: brands_pkey; Type: CONSTRAINT; Schema: public; Owner: masterNielson; Tablespace: 
--

ALTER TABLE ONLY brands
    ADD CONSTRAINT brands_pkey PRIMARY KEY (id);


--
-- Name: stores_brands_pkey; Type: CONSTRAINT; Schema: public; Owner: masterNielson; Tablespace: 
--

ALTER TABLE ONLY stores_brands
    ADD CONSTRAINT stores_brands_pkey PRIMARY KEY (id);


--
-- Name: stores_pkey; Type: CONSTRAINT; Schema: public; Owner: masterNielson; Tablespace: 
--

ALTER TABLE ONLY stores
    ADD CONSTRAINT stores_pkey PRIMARY KEY (id);


--
-- Name: public; Type: ACL; Schema: -; Owner: masterNielson
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM "masterNielson";
GRANT ALL ON SCHEMA public TO "masterNielson";
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

