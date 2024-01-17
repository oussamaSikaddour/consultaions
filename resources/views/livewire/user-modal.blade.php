@php
   $form = ($id !== '') ? 'updateForm' : 'addForm';

if (Auth::user()->userable_type==="admin_service"){
    $specialtyOptionsdata =  app('my_constants')['SPECIALTY_OPTIONS'][app()->getLocale()] ;
 }
@endphp

<div class="form__container">

    <form
    class="form"
    wire:submit="handleSubmit" >
        @if ($id ==="")
        <h3>@lang('modals.user.h3')</h3>
        @endif

        <div>

            <x-input
            name="{{$form}}.last_name"
            :label="__('modals.user.l-name')"
             type="text"
            html_id="{{ $id }}-LastName"  />
            <x-input
            name="{{$form}}.first_name"
             :label="__('modals.user.f-name')"
              type="text"
              html_id="{{ $id }}-FirstName"  />
        </div>
        @if (Auth::user()->userable_type ==="admin_service")
        <div>
        <x-selector
         htmlId="mu-specialty"
         name="{{ $form }}.specialty"
         :label="__('modals.user.specialty')"
         :data="$specialtyOptionsdata"
         :showError="true"
         />
        </div>
        @endif
       @if($id==="")
       <div>
        <x-input
        name="{{$form}}.birth_date"
        :label="__('modals.user.b-date')"
        type="date"
        html_id="{{$id}}-BrithDate"  />
        <x-input
         name="{{$form}}.email"
         :label="__('modals.user.email')"
         type="email"
          html_id="{{ $id }}-Email" />
       </div>
        <div>
         <x-input
         name="{{$form}}.tel"
         :label="__('modals.user.tel')"
         type="text"
         html_id="{{ $id }}-Tel" />
         </div>

       @else
       <div>
        <x-input
        name="{{$form}}.birth_date"
        :label="__('modals.user.b-date')"
        type="date"
        html_id="{{ $id }}-BrithDate"  />
         <x-input
         name="{{$form}}.tel"
         :label="__('modals.user.tel')"
         type="text"
         html_id="{{$id}}-Tel" />
        </div>

       @endif
        <div class="form__actions">
            <div wire:loading>
                <x-loading  />
           </div>
            <button type="submit" class="button button--primary">@lang('modals.common.submit-btn')</button>
        </div>
    </form>

</div>
