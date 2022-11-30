<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {

        DB::unprepared('
        CREATE OR REPLACE FUNCTION generate_suffix()
        RETURNS trigger AS $$
        BEGIN
            SELECT COUNT(nickname) as count FROM users WHERE nickname = NEW.nickname;
            UPDATE users SET NEW.suffix = "#" + TO_CHAR(count + 1, "000");
            RETURN NULL;
        END
        $$ LANGUAGE plpgsql;

        CREATE TRIGGER nickname_suffix_trigger
        AFTER UPDATE OF nickname ON users
        FOR EACH ROW
        EXECUTE PROCEDURE generate_suffix()
        ');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared(DB::raw("
        DROP TRIGGER IF EXISTS nickname_suffix_trigger ON users;
        DROP FUNCTION IF EXISTS generate_suffix;
        "));
    }
};
