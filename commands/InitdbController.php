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
        $this->cleanUp();
        $this->createTables();
        $this->insertData();

        return ExitCode::OK;
    }

    private function cleanUp()
    {
        $db = Yii::$app->db;

        echo "Cleaning up...\n";
        $db->createCommand("DROP TABLE IF EXISTS enrollment;")->execute();
        $db->createCommand("DROP TABLE IF EXISTS class;")->execute();
        $db->createCommand("DROP TABLE IF EXISTS student;")->execute();
        $db->createCommand("DROP TABLE IF EXISTS teacher;")->execute();
    }

    private function createTables()
    {
        $db = Yii::$app->db;

        echo "Creating student table...\n";
        $db->createCommand("
            CREATE TABLE student (
                id int unsigned NOT NULL AUTO_INCREMENT,
                name varchar(255) NOT NULL,
                year int(4) NOT NULL,
                address text DEFAULT NULL,
                PRIMARY KEY (`id`)
            )
        ")->execute();

        echo "Creating teacher table...\n";
        $db->createCommand("
            CREATE TABLE teacher (
                id int unsigned NOT NULL AUTO_INCREMENT,
                name varchar(255) NOT NULL,
                phone bigint unsigned NOT NULL,
                address text DEFAULT NULL,
                subject varchar(255) NOT NULL,
                PRIMARY KEY (`id`)
            )
        ")->execute();

        echo "Creating class table...\n";
        $db->createCommand("
            CREATE TABLE class (
                id int unsigned NOT NULL AUTO_INCREMENT,
                name varchar(255) NOT NULL,
                schedule varchar(255) NOT NULL,
                teacher_id int unsigned NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (`teacher_id`) REFERENCES teacher(`id`) ON DELETE RESTRICT
            )
        ")->execute();

        echo "Creating enrollment table...\n";
        $db->createCommand("
            CREATE TABLE enrollment (
                id int unsigned NOT NULL AUTO_INCREMENT,
                class_id int unsigned NOT NULL,
                student_id int unsigned NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (`class_id`) REFERENCES class(`id`) ON DELETE CASCADE,
                FOREIGN KEY (`student_id`) REFERENCES student(`id`) ON DELETE CASCADE,
                UNIQUE (`class_id`, `student_id`)
            )
        ")->execute();
    }

    private function insertData()
    {
        $db = Yii::$app->db;

        echo "Inserting students...\n";
        $db->createCommand("
            INSERT INTO student (`id`, `name`, `year`, `address`) VALUES
            (1, 'Morty Smith', 2, \"102 Pinewood Dr.\\nGreenville, SC\\n29680\"),
            (2, 'Rick Sanchez', 3, null),
            (3, 'Jerry Smith', 4, null)
        ")->execute();

        //1612 havenhurst drive, Hollywood CA 12345
        echo "Inserting teachers...\n";
        $db->createCommand("
            INSERT INTO teacher (`id`, `name`, `phone`, `address`, `subject`) VALUES
            (1, 'Beth Smith', 5551234567, \"1612 Havenhurst Dr.\\nHollywood, CA\\n12345\", 'Horse Doctory'),
            (2, 'Mister Meeseeks', 5551234567, 'A Box', 'Anything')
        ")->execute();

        echo "Inserting classes...\n";
        $db->createCommand("
            INSERT INTO class (`id`, `name`, `schedule`, `teacher_id`) VALUES
            (1, 'Remedial Golf', '10AM', 2),
            (2, 'Intro To Horse Surgery', '1PM', 1)
        ")->execute();

        echo "Inserting enrollments...\n";
        $db->createCommand("
            INSERT INTO enrollment (`student_id`, `class_id`) VALUES 
            (3, 1),
            (1, 2)
        ")->execute();
    }
}
