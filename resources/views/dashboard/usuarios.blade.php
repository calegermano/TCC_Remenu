<x-layout>
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Gerenciar Administradores</h1>
            <a href="{{ route('home2') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar para Página Principal
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Lista de Administradores -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Administradores Cadastrados (tipo_id = 1)</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Verificado</th>
                                <th>Data de Cadastro</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admins as $admin)
                            <tr>
                                <td>{{ $admin->id }}</td>
                                <td>{{ $admin->nome }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>
                                    @if($admin->email_verified_at)
                                        <span class="badge badge-success">Sim</span>
                                    @else
                                        <span class="badge badge-warning">Não</span>
                                    @endif
                                </td>
                                <td>{{ $admin->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($admin->id != auth()->id())
                                    <form action="{{ route('admin.usuarios.delete', $admin->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja deletar este administrador?')">
                                            <i class="fas fa-trash"></i> Deletar
                                        </button>
                                    </form>
                                    @else
                                    <span class="text-muted">(Você)</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Formulário para Adicionar Novo Administrador -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Adicionar Novo Administrador</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.usuarios.add-admin') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome') }}" required>
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" class="form-control @error('senha') is-invalid @enderror" id="senha" name="senha" required>
                        @error('senha')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="senha_confirmation">Confirmar Senha</label>
                        <input type="password" class="form-control" id="senha_confirmation" name="senha_confirmation" required>
                    </div>
                    <div class="alert alert-info">
                        <small>
                            <i class="fas fa-info-circle"></i> 
                            Este usuário será criado automaticamente como <strong>Administrador (tipo_id = 1)</strong>
                        </small>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Adicionar Administrador
                    </button>
                </form>
            </div>
        </div>

    </div>

    @push('styles')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    @endpush

    @push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    
    <!-- Page level custom scripts -->
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json'
                },
                order: [[0, 'desc']]
            });
        });
    </script>
    @endpush
</x-layout>