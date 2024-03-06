<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Task::create([
            'title' => 'Refatorar login',
            'description' => 'Desenvolver uma lógica melhor para o sistema de cadastro de usuários',
            'category_id' => 4,
            'completed' => 1,
        ]);

        Task::create([
            'title' => 'Criar página inicial.',
            'description' => 'Desenvolver página inicial do site com estilização em BootStrap.',
            'category_id' => 3,
            'completed' => 0,
        ]);

        Task::create([
            'title' => 'Implementar lógica de cadastro',
            'description' => 'Desenvolver e aplicar lógica de cadastro de usuário com middleware de autenticação.',
            'category_id' => 2,
            'completed' => 1,
        ]);

        Task::create([
            'title' => 'Adicionar funcionalidade de criação de tarefas',
            'description' => 'Desenvolver método de criação de tarefas seguindo as regras e padrões do sistema.',
            'category_id' => null,
            'completed' => 0,
        ]);

        Task::create([
            'title' => 'Implementar sistema de notificações por e-mail',
            'description' => 'Desenvolver e aplicar o disparo de e-mails para notificar ações relacionadas às tarefas',
            'category_id' => 5,
            'completed' => 0,
        ]);
    }
}
