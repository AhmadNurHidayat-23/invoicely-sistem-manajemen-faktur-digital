@props(['status'])
<span class="badge badge-{{ $status }}"><span></span>{{ \App\Models\Invoice::STATUSES[$status] }}</span>
