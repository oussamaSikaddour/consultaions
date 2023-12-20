<div class="form__container">

    <form class="form" wire:submit.prevent="handleSubmit"  x-on:redirect-page.window="setTimeout(() => { $wire.redirectPage() }, 10000)">
        <div>
            @if(isset($this->existingRoles) && $this->existingRoles->isNotEmpty())
            <div class="checkbox__group">
            <div class="choices">
            @foreach ( $this->existingRoles as $ER)
            <x-check-box model="form.roles" value="{{ $ER->id }}" label="{{$ER->name}}" htmlId="role-m-${{ $ER->id }}"/>
            @endforeach
            @error("form.roles")
            <div class="input__error">
                {{ $message }}
            </div>
            @enderror
            </div>
            </div>
            @endif
        </div>

        <div class="form__actions">
            <div wire:loading>
                <x-loading />
            </div>
            <button type="submit" class="button button--primary">Valider</button>
        </div>
    </form>

</div>
