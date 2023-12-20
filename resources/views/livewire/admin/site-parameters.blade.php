<section class="section">
    <h2>gérer le mode maintenance</h2>
 @if ($generalSettings?->maintenance)
     <div>
    <button class="button button--primary" wire:click="downloadDatabase"> donwload dataBase</button>
    </div>
 @endif
    <div class="form__container small ">
    <form class="form" wire:submit.prevent="handleSubmit" >
        <div>

            <div class="radio__group">
            <div class="choices">

            <x-radio-button
             model="form.maintenance"
             value="1"
             label="activer"
             htmlId="m-m-rb-y"/>
            <x-radio-button
             model="form.maintenance"
             value="0"
             label="désactiver"
             htmlId="m-m-rb-n"/>
            </div>
            @error("form.maintenance")
            <div class="input__error">
                {{ $message }}
            </div>
            @enderror

            </div>
        </div>

        <div class="form__actions">
            <div wire:loading>
                <x-loading />
            </div>
            <button type="submit" class="button button--primary">Valider</button>
        </div>
    </form>

    </div>
</section>
