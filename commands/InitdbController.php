<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Initializes the database with fresh data
 */
class InitdbController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex()
    {
        $db = Yii::$app->db;
        echo "Creating student table...\n";
        $db->createCommand("DROP TABLE IF EXISTS student;")->execute();
        $db->createCommand("
            CREATE TABLE student (
                id int unsigned NOT NULL AUTO_INCREMENT,
                name varchar(255) NOT NULL,
                year int(4) NOT NULL,
                PRIMARY KEY (`id`)
            )
        ")->execute();

        echo "Inserting students...\n";
        $db->createCommand("
            INSERT INTO student (`name`, `year`) VALUES
            ('Morty Smith', 2),
            ('Rick Sanchez', 3),
            ('Jerry Smith', 4)
        ")->execute();

        return ExitCode::OK;
    }
}
