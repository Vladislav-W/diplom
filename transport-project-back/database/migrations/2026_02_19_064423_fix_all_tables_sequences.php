<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Таблица cities
        DB::statement('DROP SEQUENCE IF EXISTS cities_city_id_seq CASCADE');
        DB::statement('CREATE SEQUENCE cities_city_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1');
        DB::statement("ALTER TABLE cities ALTER COLUMN city_id SET DEFAULT nextval('cities_city_id_seq'::regclass)");
        DB::statement("SELECT setval('cities_city_id_seq', COALESCE((SELECT MAX(city_id) FROM cities), 1))");

        // Таблица organizations
        DB::statement('DROP SEQUENCE IF EXISTS organizations_organization_id_seq CASCADE');
        DB::statement('CREATE SEQUENCE organizations_organization_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1');
        DB::statement("ALTER TABLE organizations ALTER COLUMN organization_id SET DEFAULT nextval('organizations_organization_id_seq'::regclass)");
        DB::statement("SELECT setval('organizations_organization_id_seq', COALESCE((SELECT MAX(organization_id) FROM organizations), 1))");

        // Таблица responsible_people
        DB::statement('DROP SEQUENCE IF EXISTS responsible_people_responsible_person_id_seq CASCADE');
        DB::statement('CREATE SEQUENCE responsible_people_responsible_person_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1');
        DB::statement("ALTER TABLE responsible_people ALTER COLUMN responsible_person_id SET DEFAULT nextval('responsible_people_responsible_person_id_seq'::regclass)");
        DB::statement("SELECT setval('responsible_people_responsible_person_id_seq', COALESCE((SELECT MAX(responsible_person_id) FROM responsible_people), 1))");

        // Таблица cargo
        DB::statement('DROP SEQUENCE IF EXISTS cargo_cargo_id_seq CASCADE');
        DB::statement('CREATE SEQUENCE cargo_cargo_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1');
        DB::statement("ALTER TABLE cargo ALTER COLUMN cargo_id SET DEFAULT nextval('cargo_cargo_id_seq'::regclass)");
        DB::statement("SELECT setval('cargo_cargo_id_seq', COALESCE((SELECT MAX(cargo_id) FROM cargo), 1))");

        // Таблица requests
        DB::statement('DROP SEQUENCE IF EXISTS requests_request_id_seq CASCADE');
        DB::statement('CREATE SEQUENCE requests_request_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1');
        DB::statement("ALTER TABLE requests ALTER COLUMN request_id SET DEFAULT nextval('requests_request_id_seq'::regclass)");
        DB::statement("SELECT setval('requests_request_id_seq', COALESCE((SELECT MAX(request_id) FROM requests), 1))");

        // Таблица request_cargo
        DB::statement('DROP SEQUENCE IF EXISTS request_cargo_request_cargo_id_seq CASCADE');
        DB::statement('CREATE SEQUENCE request_cargo_request_cargo_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1');
        DB::statement("ALTER TABLE request_cargo ALTER COLUMN request_cargo_id SET DEFAULT nextval('request_cargo_request_cargo_id_seq'::regclass)");
        DB::statement("SELECT setval('request_cargo_request_cargo_id_seq', COALESCE((SELECT MAX(request_cargo_id) FROM request_cargo), 1))");

        // Таблица files
        DB::statement('DROP SEQUENCE IF EXISTS files_file_id_seq CASCADE');
        DB::statement('CREATE SEQUENCE files_file_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1');
        DB::statement("ALTER TABLE files ALTER COLUMN file_id SET DEFAULT nextval('files_file_id_seq'::regclass)");
        DB::statement("SELECT setval('files_file_id_seq', COALESCE((SELECT MAX(file_id) FROM files), 1))");

        // Таблица auto_park
        DB::statement('DROP SEQUENCE IF EXISTS auto_park_auto_id_seq CASCADE');
        DB::statement('CREATE SEQUENCE auto_park_auto_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1');
        DB::statement("ALTER TABLE auto_park ALTER COLUMN auto_id SET DEFAULT nextval('auto_park_auto_id_seq'::regclass)");
        DB::statement("SELECT setval('auto_park_auto_id_seq', COALESCE((SELECT MAX(auto_id) FROM auto_park), 1))");

        // Таблица drivers
        DB::statement('DROP SEQUENCE IF EXISTS drivers_driver_id_seq CASCADE');
        DB::statement('CREATE SEQUENCE drivers_driver_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1');
        DB::statement("ALTER TABLE drivers ALTER COLUMN driver_id SET DEFAULT nextval('drivers_driver_id_seq'::regclass)");
        DB::statement("SELECT setval('drivers_driver_id_seq', COALESCE((SELECT MAX(driver_id) FROM drivers), 1))");

        // Таблица distances
        DB::statement('DROP SEQUENCE IF EXISTS distances_distance_id_seq CASCADE');
        DB::statement('CREATE SEQUENCE distances_distance_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1');
        DB::statement("ALTER TABLE distances ALTER COLUMN distance_id SET DEFAULT nextval('distances_distance_id_seq'::regclass)");
        DB::statement("SELECT setval('distances_distance_id_seq', COALESCE((SELECT MAX(distance_id) FROM distances), 1))");
    }

    public function down()
    {
        // Отключаем дефолтные значения
        DB::statement('ALTER TABLE cities ALTER COLUMN city_id DROP DEFAULT');
        DB::statement('ALTER TABLE organizations ALTER COLUMN organization_id DROP DEFAULT');
        DB::statement('ALTER TABLE responsible_people ALTER COLUMN responsible_person_id DROP DEFAULT');
        DB::statement('ALTER TABLE cargo ALTER COLUMN cargo_id DROP DEFAULT');
        DB::statement('ALTER TABLE requests ALTER COLUMN request_id DROP DEFAULT');
        DB::statement('ALTER TABLE request_cargo ALTER COLUMN request_cargo_id DROP DEFAULT');
        DB::statement('ALTER TABLE files ALTER COLUMN file_id DROP DEFAULT');
        DB::statement('ALTER TABLE auto_park ALTER COLUMN auto_id DROP DEFAULT');
        DB::statement('ALTER TABLE drivers ALTER COLUMN driver_id DROP DEFAULT');
        DB::statement('ALTER TABLE distances ALTER COLUMN distance_id DROP DEFAULT');
    }
};