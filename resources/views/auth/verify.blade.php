<h2>Verifique seu e-mail</h2>
<p>Enviamos um link de confirmação para seu endereço.</p>

@if (session('message'))
    <p>{{ session('message') }}</p>
@endif

<form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <button type="submit">Reenviar link</button>
</form>
