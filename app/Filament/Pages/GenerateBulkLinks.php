<?php

namespace App\Filament\Pages;

use App\Services\GuestImportService;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class GenerateBulkLinks extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-plus';

    protected static ?string $navigationGroup = 'Manajemen Undangan';

    protected static ?string $navigationLabel = 'Import Massal & Generate Link';

    protected static ?int $navigationSort = 4;

    protected static string $view = 'filament.pages.generate-bulk-links';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Input Daftar Tamu Massal')
                    ->description('Masukkan daftar nama tamu (satu nama per baris, atau format CSV: Nama, Kategori, No WhatsApp, Domisili)')
                    ->schema([
                        Forms\Components\Textarea::make('bulk_text')
                            ->label('Daftar Tamu (Teks / CSV)')
                            ->rows(12)
                            ->placeholder("Contoh:\nBpk. Ahmad Subarjo, Keluarga, 08123456789, Garut\nIbu Siti Aminah, Sahabat, 08198765432, Bandung\nDr. Fulan, Kolega, 08111223344, Jakarta")
                            ->required()
                            ->helperText('Sistem akan otomatis membersihkan nama dan menghasilkan link URL slug yang unik tanpa bentrok.'),
                        
                        Forms\Components\TextInput::make('default_category')
                            ->label('Kategori Default (jika tidak dicantumkan per baris)')
                            ->default('Umum'),
                    ]),
            ])
            ->statePath('data');
    }

    public function submit(GuestImportService $importService): void
    {
        $state = $this->form->getState();
        $text = $state['bulk_text'] ?? '';
        $defaultCategory = $state['default_category'] ?? 'Umum';

        $lines = preg_split('/\r\n|\r|\n/', $text);
        $rows = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) {
                continue;
            }

            $parts = str_getcsv($line);
            $rows[] = [
                'name' => $parts[0] ?? '',
                'category' => (!empty($parts[1]) ? trim($parts[1]) : $defaultCategory),
                'phone' => $parts[2] ?? null,
                'address' => $parts[3] ?? null,
            ];
        }

        if (empty($rows)) {
            Notification::make()
                ->title('Tidak ada data yang diproses')
                ->warning()
                ->send();
            return;
        }

        $result = $importService->importFromRows($rows);

        Notification::make()
            ->title('Proses Generate Selesai!')
            ->body("Berhasil generate {$result['created']} tamu baru. (Dilewati: {$result['skipped']})")
            ->success()
            ->send();

        $this->form->fill();
    }
}
