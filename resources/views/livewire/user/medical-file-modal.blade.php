@php
   $form = ($id !== '') ? 'updateForm' : 'addForm';
@endphp
<div class="form__container">

    <form class="form"  wire:submit="handleSubmit" >


        <div>

            <x-input
            name="{{$form}}.last_name"
            :label="__('modals.m-file.l-name')"
            type="text"
            html_id="{{ $id }}-MFLastName"  />
            <x-input
            name="{{$form}}.first_name"
           :label="__('modals.m-file.f-name')"
             type="text"
             html_id="{{ $id }}-MfFirstName"  />
        </div>

       <div>
        <x-input
        name="{{$form}}.birth_date"
        :label="__('modals.m-file.birth-d')"
         type="date"
         html_id="{{$id}}-MFBrithDate"  />

        <x-input
        name="{{$form}}.address"
        :label="__('modals.m-file.address')"
         type="text"
          html_id="{{ $id }}-MFA"  />
       </div>
       <div>
         <x-input
         name="{{$form}}.tel"
         :label="__('modals.m-file.phone-number')"
         type="text"
          html_id="{{$id}}-MFTel" />
        </div>


        <div class="form__actions">
            <div wire:loading>
                <x-loading  />
           </div>
            <button type="submit" class="button button--primary">
              @lang("modals.common.submit-btn")
            </button>
        </div>
    </form>

</div>
