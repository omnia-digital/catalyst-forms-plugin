<div class="bg-gray-50 min-h-screen">
    <form wire:submit.prevent="save" class="p-8 space-y-8 max-w-4xl mx-auto">
        <div class="p-8 bg-white shadow">
            {{ $this->form }}
        </div>

        <x-library::button type="submit">
            Save & preview
        </x-library::button>
    </form>
</div>
