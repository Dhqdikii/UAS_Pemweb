<?php

namespace App\Filament\Admin\Resources\OrderResource\Widgets;

use Filament\Widgets\ChartWidget;

class DailyOrdersChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
