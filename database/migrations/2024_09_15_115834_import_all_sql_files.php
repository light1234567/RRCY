<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImportAllSqlFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // List of SQL files to execute
        $files = [
            database_path('sql/region.sql'),
            database_path('sql/province.sql'),
            database_path('sql/citymuni.sql'),
            database_path('sql/brgy.sql'),
            database_path('sql/centerhead.sql'),
            database_path('sql/crime_categories.sql'),
            database_path('sql/rtc_provinces.sql'),
            database_path('sql/crimes.sql'),
            database_path('sql/rtc_branches.sql'),
            database_path('sql/clients.sql'),
            database_path('sql/admissions.sql'),
            database_path('sql/distinguishing_marks.sql'),
            database_path('sql/documents_submitted.sql'),
        ];

        // Loop through each file and execute the SQL statements
        foreach ($files as $file) {
            if (File::exists($file)) {
                $sql = File::get($file);  // Read the file content
                DB::unprepared($sql);     // Run the SQL statements
            } else {
                throw new \Exception("SQL file not found: $file");
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Optionally, drop the tables created by the SQL files
        DB::unprepared('DROP TABLE IF EXISTS tbl_region, tbl_province, tbl_citymuni, tbl_brgy');
    }
}
