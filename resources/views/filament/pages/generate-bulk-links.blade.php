<x-filament-panels::page>
    <form wire:submit="submit" class="space-y-6">
        {{ $this->form }}

        <div class="flex flex-col sm:flex-row justify-end gap-3 pt-2">
            <x-filament::button type="submit" size="lg" icon="heroicon-o-sparkles" class="w-full sm:w-auto">
                Generate Semua Link Sekarang
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
