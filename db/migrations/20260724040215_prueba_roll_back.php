<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class PruebaRollBack extends AbstractMigration
{
    // Lo que se ejecuta con 'phinx migrate'
    public function up(): void
    {
        $table = $this->table("users");
        if ($table->hasColumn("username")) {
            $table->renameColumn("username", "usernaem")
                  ->update();
        }
    }

    // Lo que se ejecuta con 'phinx rollback'
    public function down(): void
    {
        $table = $this->table("users");
        if ($table->hasColumn("usernaem")) {
            $table->renameColumn("usernaem", "username")
                  ->update();
        }
    }
}