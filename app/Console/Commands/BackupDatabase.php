<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use ZipArchive;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Take a backup of the database and send it via email';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Define the backup filename
        $backupFileName = 'backup-' . Carbon::now()->format('Y-m-d_H-i-s') . '.sql';

        // Run the backup using the mysqldump command
        $command = "mysqldump -u" . env('DB_USERNAME') . " -p" . env('DB_PASSWORD') . " " . env('DB_DATABASE') . " > " . storage_path('app/backups/' . $backupFileName);
        $output = null;
        $resultCode = null;

        // Run the backup command
        exec($command, $output, $resultCode);

        if ($resultCode !== 0) {
            $this->error("Database backup failed!");
            return;
        }

        // Optionally, zip the backup file
        $zip = new ZipArchive;
        $zipFileName = storage_path('app/backups/' . pathinfo($backupFileName, PATHINFO_FILENAME) . '.zip');
        if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
            $zip->addFile(storage_path('app/backups/' . $backupFileName), $backupFileName);
            $zip->close();
        }

        // Send the backup as an email attachment
        $this->sendBackupEmail($zipFileName);

        // Optionally delete the backup after sending the email
        unlink(storage_path('app/backups/' . $backupFileName));
        unlink($zipFileName);

        $this->info("Database backup completed and email sent!");
    }

    /**
     * Send the backup file via email.
     *
     * @param string $file
     * @return void
     */
    protected function sendBackupEmail($file)
    {
        $toEmail = 'deepakprasad224@gmail.com'; // Replace with the recipient's email address

        Mail::send([], [], function ($message) use ($toEmail, $file) {
            $message->to($toEmail)
                ->subject('Database Backup - ' . Carbon::now()->format('Y-m-d'))
                ->attach($file, [
                    'as' => 'database-backup.zip',
                    'mime' => 'application/zip',
                ])
                ->setBody('Please find the database backup attached.');
        });
    }
}
