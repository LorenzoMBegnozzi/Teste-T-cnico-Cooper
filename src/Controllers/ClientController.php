<?php
require_once __DIR__ . '/../Models/Client.php';
require_once __DIR__ . '/../Core/Validator.php';

class ClientController {
    private Client $model;

    public function __construct() {
        $this->model = new Client();
    }

    public function index(): void {
        $clients = $this->model->all();
        include __DIR__ . '/../Views/list.php';
    }

    public function create(): void {
        $errors = [];
        $old = ['name'=>'','email'=>'','cpf'=>'','phone'=>''];
        include __DIR__ . '/../Views/create.php';
    }

    public function store(): void {
        $v = new Validator();
        $name  = $_POST['name']  ?? '';
        $email = $_POST['email'] ?? '';
        $cpf   = $_POST['cpf']   ?? '';
        $phone = $_POST['phone'] ?? '';

        // cpf apenas numeros
        $cpf = preg_replace(pattern: '/\D/', replacement: '', subject: $cpf);

        $v->required(field: 'name', value: $name, message: 'Nome é obrigatório.');
        $v->minLen(field: 'name', value: $name, min: 3, message: 'Nome deve ter pelo menos 3 caracteres.');
        $v->required(field: 'email', value: $email, message: 'Email é obrigatório.');
        $v->email(field: 'email', value: $email, message: 'Email inválido.');
        if ($phone !== '') {
            $v->regex(field: 'phone', value: $phone, pattern: '/^[0-9()\-\s+]{8,20}$/', message: 'Telefone inválido.');
        }
        $v->minLenCPF(field: 'cpf', value: $cpf, min: 11, max: 11, message: 'CPF deve ter exatamente 11 caracteres.');
        //$v->minLenCPF(field: 'cpf', value: $cpf, length: 11, message: 'CPF deve ter exatamente 11 caracteres.');


        //emal ja usado
        if ($this->model->existsEmail(email: $email)) {
            $errors = $v->errors();
            $errors['email'][] = 'Email já cadastrado.';
            $old = compact('name','email','cpf','phone');
            include __DIR__ . '/../Views/create.php';
            return;
        }

        // cpf ja usado
        if($this->model->existsCpf(cpf: $cpf)) {
            $errors = $v->errors();
            $errors['cpf'][] = 'CPF já cadastrado.';
            $old = compact('name','email','cpf','phone');
            include __DIR__ . '/../Views/create.php';
            return;
        }

        if (!$v->ok()) {
            $errors = $v->errors();
            $old = compact('name','email','cpf','phone'); //mesmo depois do erro, continua preenchido
            include __DIR__ . '/../Views/create.php';
            return;
        }

        $this->model->create(data: [
            'name'  => $name,
            'email' => $email,
            'cpf'   => $cpf,
            'phone' => $phone
        ]);

        header(header: 'Location: /clients');
    }

    //carrega dados do cliente para ediçao
    public function edit(int $id): void {
        $client = $this->model->find(id: $id);
        if (!$client) {
            http_response_code(response_code: 404);
            echo 'Cliente não encontrado';
            return;
        }
        $errors = [];
        $old = $client;
        include __DIR__ . '/../Views/edit.php';
    }

    //atualizar dados do cliente
    public function update(int $id): void {
        $client = $this->model->find(id: $id);
        if (!$client) {
            http_response_code(response_code: 404);
            echo 'Cliente não encontrado';
            return;
        }

        $v = new Validator();
        $name  = $_POST['name']  ?? '';
        $email = $_POST['email'] ?? '';
        $cpf   = $_POST['cpf']   ?? '';
        $phone = $_POST['phone'] ?? '';

        $cpf = preg_replace(pattern: '/\D/', replacement: '', subject: $cpf);

        $v->required(field: 'name', value: $name, message: 'Nome é obrigatório.');
        $v->minLen(field: 'name', value: $name, min: 3, message: 'Nome deve ter pelo menos 3 caracteres.');
        $v->required(field: 'email', value: $email, message: 'Email é obrigatório.');
        $v->email(field: 'email', value: $email, message: 'Email inválido.');
        if ($phone !== '') {
            $v->regex('phone', value: $phone, pattern: '/^[0-9()\-\s+]{8,20}$/', message: 'Telefone inválido.');
        }
        $v->minLenCPF(field: 'cpf', value: $cpf, min: 11, max: 11, message: 'CPF deve ter exatamente 11 caracteres.');

        //$v->minLenCPF(field: 'cpf', value: $cpf, length: 11, message: 'CPF deve ter exatamente 11 caracteres.');

        // duplicidade de email
        if ($this->model->existsEmail(email: $email, ignoreId: $id)) {
            $errors = $v->errors();
            $errors['email'][] = 'Email já cadastrado.';
            $old = compact('id','name','email','cpf','phone');
            include __DIR__ . '/../Views/edit.php';
            return;
        }   

        if($this->model->existsCpf(cpf: $cpf, ignoreId: $id)) {
            $errors = $v->errors();
            $errors['cpf'][] = 'CPF já cadastrado.';
            $old = compact('id','name','email','cpf','phone');
            include __DIR__ . '/../Views/edit.php';
            return;
        }
        
        if (!$v->ok()) {
            $errors = $v->errors();
            $old = compact('id','name','email','cpf','phone');
            include __DIR__ . '/../Views/edit.php';
            return;
        }

        $this->model->update(id: $id, data: [
            'name'  => $name,
            'email' => $email,
            'cpf'   => $cpf,
            'phone' => $phone
        ]);

        header(header: 'Location: /clients');
    }

    //excluir cliente
    public function delete(int $id): void {
        $this->model->delete(id: $id);
        header(header: 'Location: /clients');
    }
}
