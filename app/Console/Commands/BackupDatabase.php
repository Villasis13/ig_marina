<?php

namespace App\Console\Commands;

use App\Models\Logs;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class BackupDatabase extends Command
{
    private $logs;
    public function __construct()
    {
        parent::__construct(); // Llama al constructor de la clase padre

        $this->logs = new Logs(); // Inicializa el objeto Logs
    }

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
    protected $description = 'Backup the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {

            $backupPath = storage_path('backups');
            // Eliminar todos los archivos de respaldo antiguos
            $files = scandir($backupPath);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    unlink($backupPath . '/' . $file);
                }
            }

            $filename = 'backup_' . date('Y-m-d') . '.sql';
            $path = $backupPath . '/' . $filename;

            // Realizar el respaldo de la base de datos
            $databaseUser = config('database.connections.mysql.username');
            $databasePass = config('database.connections.mysql.password');
            $databaseName = config('database.connections.mysql.database');

            $command = sprintf(
                'mysqldump -u%s %s > %s',
                $databaseUser,
                $databaseName,
                $path
            );

            exec($command);
            // Enviar el respaldo por correo electrónico
            Mail::raw('Adjunto el respaldo de la base de datos', function ($message) use ($path) {
                $message->to('reynaalfredo421@gmail.com')
                    ->subject('Respaldo de la base de datos ASSU Dent '.date('d-m-Y',strtotime(date('Y-m-d'))))
                    ->from('soporte@emyspets.com', "eder")
                    ->attach($path);
            });
        }catch (\Exception $e) {
            $this->logs->insertarLog($e);
        }
//        $this->info('Database backed up successfully to ' . $path);
    }
}
