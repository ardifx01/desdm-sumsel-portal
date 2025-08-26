@props(['disabled' => false])

<div x-data="{ show: false }" class="input-group">
    <input {{ $disabled ? 'disabled' : '' }}
           :type="show ? 'text' : 'password'"
           {!! $attributes->merge(['class' => 'form-control']) !!}>
    
    <button class="btn btn-outline-secondary" type="button" @click="show = !show" aria-label="Toggle password visibility">
        <i :class="show ? 'bi-eye-slash-fill' : 'bi-eye-fill'"></i>
    </button>
</div>