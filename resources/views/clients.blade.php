@extends("base")
@section("title")Все Клиенты@endsection
@section("content")
<nav>
    <a href="{{ route('clients-index') }}" rel="tag">✎ Добавить клиента</a>
</nav>
<table class="table">
    <thead>
        <th>ФИО</th>
        <th>Модель</th>
        <th>Гос. Номер РФ</th>
        <th>Действия</th>
    </thead>
    <tbody>
    @foreach($clients as $client)
    <tr data-phone-number="{{ $client->phone_number }}" data-ru-vehicle-registration="{{ $client->ru_vehicle_registration }}">
        <td>{{ $client->full_name }}</td>
        <td>{{ $client->model }}</td>
        <td>{{ $client->ru_vehicle_registration }}</td>
        <td>
            <a href="{{ route('clients-show', ['phoneNumber' => $client->phone_number]) }}" class="btn btn-primary">✎ </a>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
{{ $clients->links() }}
<script>
// TODO: Use Webpack and move to external file
"use strict"

for(const row of document.querySelectorAll("tbody > *")) {
    const btn = document.createElement("button")
    btn.textContent = "X"
    btn.classList.add("btn")
    btn.classList.add("btn-danger")
    btn.classList.add("mx-2")
    btn.addEventListener("click", () => {
        row.remove()
        console.log(row.dataset.phoneNumber)
        const dataset = row.dataset
        fetch(`/clients/${dataset.phoneNumber}/vehicles/${dataset.ruVehicleRegistration}`, {
          method: "DELETE",
          headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
          }
        })
    })
    row.lastElementChild.append(btn)
}
</script>
@endsection
