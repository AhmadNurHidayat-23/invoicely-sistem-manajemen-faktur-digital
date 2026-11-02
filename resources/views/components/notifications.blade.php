@if(session('success'))
    <div class="notice notice-success" role="status"><x-icon name="check"/><span>{{ session('success') }}</span></div>
@endif
@if(session('error'))
    <div class="notice notice-error" role="alert"><x-icon name="info"/><span>{{ session('error') }}</span></div>
@endif
@if($errors->any())
    <div class="notice notice-error" role="alert" tabindex="-1" data-validation-errors>
        <x-icon name="info"/>
        <div><strong>Periksa kembali isian Anda.</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    </div>
@endif
