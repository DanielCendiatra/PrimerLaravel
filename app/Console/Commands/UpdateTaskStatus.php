<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use Carbon\Carbon;

class UpdateTaskStatus extends Command
{
    protected $signature = 'tasks:update-status';
    protected $description = 'Actualizar el estado de las tareas según la fecha de entrega';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $tasks = Task::where('estado', '!=', 'Finalizada')
            ->where('tarea_date', '<', Carbon::now())
            ->update(['estado' => 'Finalizada']);

        $this->info('Estados de las tareas actualizados correctamente.');
    }
}