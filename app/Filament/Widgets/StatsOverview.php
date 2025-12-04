<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Consultation;
use App\Models\User;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pengguna', User::count())
                ->description('Jumlah semua pengguna terdaftar')
                ->color('success'),
            Stat::make('Konsultasi Terbuka', Consultation::where('status', 'open')->count())
                ->description('Konsultasi yang butuh balasan')
                ->color('danger'),
        ];
    }
}
