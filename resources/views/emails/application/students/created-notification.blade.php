@component('mail::message')
{{ $notifiable->first_name  }}, seu acesso ao APP DO TREINADOR foi criado com sucesso!

@component('mail::panel')
Use o seguinte código para acessar o APP:
<b>{{ $loginCode }}</b>
@endcomponent

Esse código é único, então salve esse e-mail/código em um local seguro para não perder acesso à sua conta.

@component('mail::panel')
Sua senha para primeiro acesso é: <b>{{ $password }}</b>
@endcomponent


@component('mail::button', ['url' => $appStoreLink])
Baixar Aplicativo para IOS
@endcomponent

@component('mail::button', ['url' => $playStoreLink])
Baixar Aplicativo para ANDROID
@endcomponent

Parabéns por sua escolha, <br />
Equipe {{ config('app.name') }}
@endcomponent
