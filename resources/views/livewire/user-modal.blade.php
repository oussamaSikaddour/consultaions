@php
   $form = ($id !== '') ? 'updateForm' : 'addForm';

if (Auth::user()->userable_type==="admin_service"){
    $specialtyOptionsdata =  app('my_constants')['SPECIALTY_OPTIONS'] ;
 }
@endphp

<div class="form__container">

    <form class="form"  wire:submit="handleSubmit" >
        @if ($id ==="")
        <h3>L'email doit être valide, un code de vérification lui sera envoyé</h3>
        @endif

        <div>

            <x-input name="{{$form}}.last_name" label="Nom"  type="text" html_id="{{ $id }}-LastName"  />
            <x-input name="{{$form}}.first_name" label="Prénom"  type="text" html_id="{{ $id }}-FirstName"  />
        </div>
        @if (Auth::user()->userable_type ==="admin_service")
        <div>
        <x-selector
         htmlId="mu-specialty"
         name="{{ $form }}.specialty"
         label="spécialité"
         :data="$specialtyOptionsdata"
         :showError="true"
         />
        </div>
        @endif
       @if($id==="")
       <div>
        <x-input name="{{$form}}.birth_date" label="Date de naissance"  type="date" html_id="{{$id}}-BrithDate"  />
        <x-input name="{{$form}}.email" label="Email"  type="email" html_id="{{ $id }}-Email" />
       </div>
        <div>
         <x-input name="{{$form}}.tel" label="tel"  type="text" html_id="{{ $id }}-Tel" />
         </div>

       @else
       <div>
        <x-input name="{{$form}}.birth_date" label="Date de naissance"  type="date" html_id="{{ $id }}-BrithDate"  />
         <x-input name="{{$form}}.tel" label="tel"  type="text" html_id="{{$id}}-Tel" />
        </div>

       @endif
        <div class="form__actions">
            <div wire:loading>
                <x-loading  />
           </div>
            <button type="submit" class="button button--primary">Valider</button>
        </div>
    </form>

</div>
