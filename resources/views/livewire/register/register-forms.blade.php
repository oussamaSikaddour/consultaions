

<div class="forms"
     x-bind:class="{ 'slide': isSlideUpdated }"
     x-data="{ isSlideUpdated: {{ $isSlide ? 'true' : 'false' }} }"
     x-on:is-slide-updated.window="
         isSlideUpdated = $event.detail[0]
     "
>
    <livewire:register.first-form />
    <livewire:register.second-form />
</div
