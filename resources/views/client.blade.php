@extends("base")
@section("title")Добавление/Изменение Клиента@endsection
@section("content")
@php ($cs = isset($client))
<nav>
    <a href="{{ route('main-index') }}" rel="tag">⁞ Все клиенты</a>
</nav>
@if($errors->any())
<ul class="alert alert-danger">
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
<ul>
@endif
<form action="{{ route('clients-store') }}" method="post">
    @csrf
    <h2>Клиент</h2>
    <fieldset class="px-4">
        <legend class="form-text text-muted">Информация о клиенте</legend>
        <div class="input-group mb-2">
            <label for="full_name" class="input-group-text">ФИО</label>
            <input name="full_name" @if($cs) value="{{ $client->full_name }}" @endif placeholder="Иванов Иван Иваныч" minlength="3" required class="form-control">
        </div>
        <div class="input-group mb-2">
            <label for="phone_number" class="input-group-text">Номер телефона</label>
            <input name="phone_number" @if($cs) value="{{ $client->phone_number }}" @endif placeholder="70000000000" maxlength="15" required class="form-control form-control-lg">
        </div>
        <div class="form-group mb-2">
            <label for="gender">Пол</label>
            <select name="gender" class="form-select">
                <option @if($cs == false || $client->gender == 'male') selected @endif value="male">Мужской</option>
                <option @if($cs && $client->gender == 'female') selected @endif value="female">Женский</option>
                <option @if($cs && $client->gender == 'unspecified') selected @endif value="unspecified">Другой</option>
            </select>
        </div>
        <div class="input-group mb-2">
            <label for="address" class="input-group-text">Адрес</label>
            <input name="address" @if($cs) value="{{ $client->address }}" @endif placeholder="ул. Ленина (необязательно)" class="form-control form-control-sm">
        </div>
    </fieldset>
    <h2>Автомобили</h2>
    <div class="vehicles">
        @foreach($vehicles as $vehicle)
        <fieldset class="px-4">
            <legend class="form-text text-muted">Информация о транспортном средстве</legend>
            <div class="input-group mb-2">
                <label for="brand[]" class="input-group-text">Марка</label>
                <input name="brand[]" value="{{ $vehicle->brand }}" placeholder="BMW" class="form-control">
            </div>
            <div class="input-group mb-2">
                <label for="model[]" class="input-group-text">Модель</label>
                <input name="model[]" value="{{ $vehicle->model }}" class="form-control">
            </div>
            <div class="input-group mb-2">
                <label for="color[]" class="input-group-text">Цвет</label>
                <input name="color[]" value="{{ $vehicle->color }}" placeholder="Розовый" class="form-control">
            </div>
            <div class="input-group mb-2">
                <label for="ru_vehicle_registration[]" class="input-group-text">Гос. Номер РФ</label>
                <input name="ru_vehicle_registration[]" value="{{ $vehicle->ru_vehicle_registration }}" placeholder="м777мм77" class="form-control">
            </div>
            <div class="form-group mb-2">
                <input name="in_parking[]" value="{{ $vehicle->ru_vehicle_registration }}" @if($vehicle->in_parking) checked @endif type="checkbox" class="form-check-input" class="form-control">
                <label for="in_parking[]">На парковке?</label>
            </div>
        </fieldset>
        @endforeach
    </div>
    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>

<script>
// TODO: Use Webpack and move to external file
"use strict"

for(const vehicleLegend of document.querySelectorAll(".vehicles fieldset:not(:last-child) legend")) {
    const btn = document.createElement("button")
    btn.textContent = "Удалить"
    btn.classList.add("btn")
    btn.classList.add("btn-danger")
    btn.classList.add("mx-2")
    btn.addEventListener("click", () => {
        vehicleLegend.parentElement.remove()
    })
    vehicleLegend.append(btn)
}
</script>
@endsection
