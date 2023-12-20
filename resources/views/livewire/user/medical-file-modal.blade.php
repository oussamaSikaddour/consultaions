@php
   $form = ($id !== '') ? 'updateForm' : 'addForm';
@endphp
<div class="form__container">

    <form class="form"  wire:submit="handleSubmit" >


        <div>

            <x-input name="{{$form}}.last_name" label="Nom"  type="text"
            html_id="{{ $id }}-MFLastName"  />
            <x-input name="{{$form}}.first_name" label="Prénom"  type="text"
             html_id="{{ $id }}-MfFirstName"  />
        </div>

       <div>
        <x-input name="{{$form}}.birth_place" label="Lieu de naissance"  type="text" html_id="{{$id}}-MFBrithDate"  />
        <x-input name="{{$form}}.birth_date" label="Date de naissance"  type="date" html_id="{{$id}}-MFBrithDate"  />
       </div>

        <div>
        <x-input name="{{$form}}.address" label="adresse"  type="text" html_id="{{ $id }}-MFA"  />
         <x-input name="{{$form}}.tel" label="tel"  type="text" html_id="{{$id}}-MFTel" />
        </div>


        <div class="form__actions">
            <div wire:loading>
                <x-loading  />
           </div>
            <button type="submit" class="button button--primary">Valider</button>
        </div>
    </form>

</div>
