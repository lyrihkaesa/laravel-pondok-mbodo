<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use Filament\Forms;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Saade\FilamentFullCalendar\Actions;

class CalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = Event::class;

    protected function headerActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mountUsing(
                    function (Forms\Form $form, array $arguments) {
                        $form->fill([
                            'color' => '#a3e635',
                            'start' => $arguments['start'] ?? null,
                            'end' => $arguments['end'] ?? null,
                        ]);
                    }
                ),
        ];
    }

    protected function modalActions(): array
    {
        return [
            Actions\EditAction::make()
                ->mountUsing(
                    function (Event $record, Forms\Form $form, array $arguments) {
                        $form->fill([
                            'title' => $record->title,
                            'location' => $record->location,
                            'description' => $record->description,
                            'color' => $record->color,
                            'start' => $arguments['event']['start'] ?? $record->start,
                            'end' => $arguments['event']['end'] ?? $record->end,
                        ]);
                    }
                ),
            Actions\DeleteAction::make(),
        ];
    }

    public function fetchEvents(array $fetchInfo): array
    {
        return Event::query()
            ->where('start', '>=', $fetchInfo['start'])
            ->where('end', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn (Event $event) => [
                    'id' => $event->id,
                    'title' => $event->title,
                    'location' => $event->location,
                    'description' => $event->description,
                    'color' => $event->color,
                    'start' => $event->start,
                    'end' => $event->end,
                ]
            )
            ->all();
    }

    public function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255),
            Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\TextInput::make('location')
                        ->maxLength(255),
                    Forms\Components\ColorPicker::make('color'),
                ]),
            Forms\Components\Textarea::make('description')
                ->columnSpanFull(),
            Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\DateTimePicker::make('start')
                        ->required(),
                    Forms\Components\DateTimePicker::make('end')
                        ->required(),
                ]),
        ];
    }

    public function eventDidMount(): string
    {
        return <<<JS
        function({ event, timeText, isStart, isEnd, isMirror, isPast, isFuture, isToday, el, view }){
            el.setAttribute("x-tooltip", "tooltip");
            el.setAttribute("x-data", "{ tooltip: '"+event.title+"' }");
        }
    JS;
    }
}
