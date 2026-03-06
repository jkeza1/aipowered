<?php
use PHPUnit\Framework\TestCase;

class AllPhpFilesTest extends TestCase
{
    public function test_all_php_files_include()
    {
        $phpFiles = [
            'applicationcourtjudgment.php',
            'applicationcertificateofcelibacy.php',
            'applicationbankstatementmodal.php',
            'applicationbankstatement.php',
            'applicationacademictranscriptmodal.php',
            'applicationacademictranscript.php',
            'userdashboard.php',
            'update_tables.php',
            'update_db_name.php',
            'adminsection/systeminfo.php',
            'login.php',
            'list_tables.php',
            'terms.php',
            'adminsection/servicemanagement.php',
            'database/seed_registry.php',
            'database/check_structure.php',
            'lib/waypoints/links.php',
            'backendcodes/sessionstart.php',
            'backendcodes/sessioncheck.php',
            'backendcodes/sendapplicationsalarycertificate.php',
            // ...add more as needed
        ];
        foreach ($phpFiles as $file) {
            $this->assertFileExists(__DIR__ . '/../' . $file, "File $file does not exist");
            // Optionally, try including the file to check for syntax errors
            try {
                include_once __DIR__ . '/../' . $file;
                $this->assertTrue(true);
            } catch (\Throwable $e) {
                $this->fail("Error including $file: " . $e->getMessage());
            }
        }
    }
}
