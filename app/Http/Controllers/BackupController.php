<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class BackupController extends Controller
{
    /**
     * Show backup page
     */
    public function showBackupForm()
    {
        return view('backup.create');
    }


    /**
     * Create database backup
     *
     * Backup location:
     * D:\backups\
     */
    public function createBackup()
    {
        // =========================================================
        // DATABASE CONFIGURATION
        // =========================================================

        $databaseName = env('DB_DATABASE');
        $databaseUser = env('DB_USERNAME');
        $databasePassword = env('DB_PASSWORD', '');
        $host = env('DB_HOST', '127.0.0.1');
        $port = env('DB_PORT', '3306');


        // =========================================================
        // XAMPP MYSQLDUMP LOCATION
        // =========================================================

        $mysqldump = 'D:/xampp/mysql/bin/mysqldump.exe';


        // =========================================================
        // BACKUP DIRECTORY
        // D:\backups\
        // =========================================================

        $backupPath = 'D:/backups/';


        // =========================================================
        // CHECK DATABASE NAME
        // =========================================================

        if (empty($databaseName)) {

            return redirect()->back()->with(
                'error',
                'Database name is not configured in .env'
            );
        }


        // =========================================================
        // CHECK DATABASE USER
        // =========================================================

        if (empty($databaseUser)) {

            return redirect()->back()->with(
                'error',
                'Database username is not configured in .env'
            );
        }


        // =========================================================
        // CHECK MYSQLDUMP
        // =========================================================

        if (!file_exists($mysqldump)) {

            return redirect()->back()->with(
                'error',
                'mysqldump.exe not found at: ' . $mysqldump
            );
        }


        // =========================================================
        // CREATE BACKUP DIRECTORY
        // =========================================================

        if (!File::exists($backupPath)) {

            try {

                File::makeDirectory(
                    $backupPath,
                    0777,
                    true
                );

            } catch (\Exception $e) {

                return redirect()->back()->with(
                    'error',
                    'Could not create backup directory: '
                    . $e->getMessage()
                );
            }
        }


        // =========================================================
        // CHECK BACKUP DIRECTORY
        // =========================================================

        if (!File::isDirectory($backupPath)) {

            return redirect()->back()->with(
                'error',
                'Backup path is not a directory: ' . $backupPath
            );
        }


        // =========================================================
        // CHECK WRITABLE
        // =========================================================

        if (!is_writable($backupPath)) {

            return redirect()->back()->with(
                'error',
                'Backup directory is not writable: ' . $backupPath
            );
        }


        // =========================================================
        // DELETE OLD BACKUPS
        // =========================================================

        $this->deleteOldBackups($backupPath);


        // =========================================================
        // CREATE BACKUP FILE NAME
        // =========================================================

        $fileName =
            'backup_' .
            date('Y-m-d_H-i-s') .
            '.sql';


        $backupFile = $backupPath . $fileName;


        // =========================================================
        // BUILD MYSQLDUMP COMMAND
        // =========================================================

        $command = '"' . $mysqldump . '"';

        $command .=
            ' --host="' .
            $host .
            '"';

        $command .=
            ' --port="' .
            $port .
            '"';

        $command .=
            ' --user="' .
            $databaseUser .
            '"';


        // =========================================================
        // ADD PASSWORD
        // =========================================================

        if (!empty($databasePassword)) {

            $command .=
                ' --password="' .
                $databasePassword .
                '"';
        }


        // =========================================================
        // DATABASE NAME
        // =========================================================

        $command .=
            ' "' .
            $databaseName .
            '"';


        // =========================================================
        // SAVE OUTPUT TO BACKUP FILE
        // =========================================================

        $command .=
            ' > "' .
            $backupFile .
            '"';


        // =========================================================
        // EXECUTE MYSQLDUMP
        // =========================================================

        $output = [];

        $result = null;


        exec(
            $command . ' 2>&1',
            $output,
            $result
        );


        // =========================================================
        // SUCCESS
        // =========================================================

        if (
            $result === 0 &&
            file_exists($backupFile) &&
            filesize($backupFile) > 0
        ) {

            Log::info(
                'Database backup created successfully: ' .
                $backupFile
            );


            return redirect()->back()->with(
                'success',
                'Backup created successfully: ' .
                $fileName
            );
        }


        // =========================================================
        // DELETE FAILED BACKUP FILE
        // =========================================================

        if (file_exists($backupFile)) {

            @unlink($backupFile);
        }


        // =========================================================
        // ERROR MESSAGE
        // =========================================================

        if (!empty($output)) {

            $errorMessage =
                implode("\n", $output);

        } else {

            $errorMessage =
                'mysqldump failed with exit code: ' .
                $result;
        }


        Log::error(
            'Database backup failed: ' .
            $errorMessage
        );


        return redirect()->back()->with(
            'error',
            'Backup failed: ' .
            $errorMessage
        );
    }


    /**
     * Show restore page
     */
    public function showRestoreForm()
    {
        // =========================================================
        // GET DATABASES
        // =========================================================

        $databases = $this->getDatabases();


        // =========================================================
        // BACKUP DIRECTORY
        // =========================================================

        $backupDirectories = [
            'D:/backups/'
        ];


        $backupFiles = [];


        // =========================================================
        // FIND BACKUP FILES
        // =========================================================

        foreach ($backupDirectories as $dir) {

            if (
                File::exists($dir) &&
                File::isDirectory($dir)
            ) {

                $files =
                    glob(
                        $dir .
                        'backup_*.sql'
                    );


                if ($files) {

                    $backupFiles =
                        array_merge(
                            $backupFiles,
                            $files
                        );
                }
            }
        }


        // =========================================================
        // SORT NEWEST FIRST
        // =========================================================

        usort(
            $backupFiles,
            function ($a, $b) {

                return
                    filemtime($b)
                    <=>
                    filemtime($a);
            }
        );


        // =========================================================
        // RETURN VIEW
        // =========================================================

        return view(
            'backup.restore',
            compact(
                'databases',
                'backupFiles'
            )
        );
    }


    /**
     * Restore selected backup
     */
    public function restoreBackup(Request $request)
    {
        // =========================================================
        // GET DATABASE
        // =========================================================

        $database =
            $request->input('database');


        // =========================================================
        // GET UPLOADED FILE
        // =========================================================

        $file =
            $request->file('backup_file');


        // =========================================================
        // VALIDATE DATABASE
        // =========================================================

        if (empty($database)) {

            return redirect()->back()->with(
                'error',
                'Please select a database.'
            );
        }


        // =========================================================
        // VALIDATE FILE
        // =========================================================

        if (!$file) {

            return redirect()->back()->with(
                'error',
                'No backup file selected.'
            );
        }


        // =========================================================
        // VALIDATE SQL FILE
        // =========================================================

        $extension =
            strtolower(
                $file->getClientOriginalExtension()
            );


        if ($extension !== 'sql') {

            return redirect()->back()->with(
                'error',
                'Only .sql backup files are allowed.'
            );
        }


        // =========================================================
        // UPLOAD DIRECTORY
        // =========================================================

        $uploadPath =
            'D:/backups/uploads/';


        // =========================================================
        // CREATE UPLOAD DIRECTORY
        // =========================================================

        if (!File::exists($uploadPath)) {

            File::makeDirectory(
                $uploadPath,
                0777,
                true
            );
        }


        // =========================================================
        // CREATE SAFE FILE NAME
        // =========================================================

        $fileName =
            time() .
            '_' .
            preg_replace(
                '/[^A-Za-z0-9_\-.]/',
                '_',
                $file->getClientOriginalName()
            );


        // =========================================================
        // FULL FILE PATH
        // =========================================================

        $backupFile =
            $uploadPath .
            $fileName;


        // =========================================================
        // MOVE UPLOADED FILE
        // =========================================================

        try {

            $file->move(
                $uploadPath,
                $fileName
            );

        } catch (\Exception $e) {

            return redirect()->back()->with(
                'error',
                'Could not upload backup file: ' .
                $e->getMessage()
            );
        }


        // =========================================================
        // CHECK FILE
        // =========================================================

        if (!file_exists($backupFile)) {

            return redirect()->back()->with(
                'error',
                'Backup file does not exist.'
            );
        }


        // =========================================================
        // XAMPP MYSQL LOCATION
        // =========================================================

        $mysql =
            'D:/xampp/mysql/bin/mysql.exe';


        // =========================================================
        // CHECK MYSQL.EXE
        // =========================================================

        if (!file_exists($mysql)) {

            return redirect()->back()->with(
                'error',
                'mysql.exe not found at: ' .
                $mysql
            );
        }


        // =========================================================
        // DATABASE CONFIGURATION
        // =========================================================

        $username =
            env('DB_USERNAME');

        $password =
            env('DB_PASSWORD', '');

        $host =
            env(
                'DB_HOST',
                '127.0.0.1'
            );

        $port =
            env(
                'DB_PORT',
                '3306'
            );


        // =========================================================
        // BUILD MYSQL RESTORE COMMAND
        // =========================================================

        $command =
            '"' .
            $mysql .
            '"';


        $command .=
            ' --host="' .
            $host .
            '"';


        $command .=
            ' --port="' .
            $port .
            '"';


        $command .=
            ' --user="' .
            $username .
            '"';


        // =========================================================
        // ADD PASSWORD
        // =========================================================

        if (!empty($password)) {

            $command .=
                ' --password="' .
                $password .
                '"';
        }


        // =========================================================
        // DATABASE
        // =========================================================

        $command .=
            ' "' .
            $database .
            '"';


        // =========================================================
        // SQL FILE
        // =========================================================

        $command .=
            ' < "' .
            $backupFile .
            '"';


        // =========================================================
        // EXECUTE RESTORE
        // =========================================================

        $output = [];

        $result = null;


        exec(
            $command . ' 2>&1',
            $output,
            $result
        );


        // =========================================================
        // LOG
        // =========================================================

        Log::info(
            'Database restore attempted.'
        );

        Log::info(
            'Database: ' .
            $database
        );

        Log::info(
            'Restore file: ' .
            $backupFile
        );

        Log::info(
            'Restore output: ' .
            implode("\n", $output)
        );


        // =========================================================
        // SUCCESS
        // =========================================================

        if ($result === 0) {

            // Delete temporary uploaded file
            if (file_exists($backupFile)) {

                @unlink($backupFile);
            }


            return redirect()->back()->with(
                'success',
                'Backup restored successfully.'
            );
        }


        // =========================================================
        // RESTORE FAILED
        // =========================================================

        $errorMessage =
            !empty($output)
            ? implode("\n", $output)
            : 'mysql failed with exit code: ' .
              $result;


        return redirect()->back()->with(
            'error',
            'Restore failed: ' .
            $errorMessage
        );
    }


    /**
     * Get all databases
     */
    private function getDatabases()
    {
        $databases =
            DB::select(
                'SHOW DATABASES'
            );


        return collect($databases)
            ->pluck('Database')
            ->toArray();
    }


    /**
     * Delete old backups
     *
     * This deletes existing backup_*.sql files
     * before creating the new backup.
     */
    private function deleteOldBackups($backupPath)
    {
        $files =
            glob(
                $backupPath .
                'backup_*.sql'
            );


        if (!$files) {
            return;
        }


        foreach ($files as $file) {

            if (file_exists($file)) {

                @unlink($file);
            }
        }
    }
}
