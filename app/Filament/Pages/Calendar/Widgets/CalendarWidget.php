<?php

namespace App\Filament\Pages\Calendar\Widgets;


use Filament\Forms;
use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Actions;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = Event::class;

    public ?array $selectedCalendarIds = [];

    protected function headerActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mountUsing(
                    function (Forms\Form $form, array $arguments) {
                        $form->fill([
                            'calendar_id' => $this->selectedCalendarIds[0] ?? null,
                            'color' => '#a3e635',
                            'start_at' => $arguments['start'] ?? null,
                            'end_at' => $arguments['end'] ?? null,
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
                            'start_at' => $arguments['event']['start'] ?? $record->start_at,
                            'end_at' => $arguments['event']['end'] ?? $record->end_at,
                        ]);
                    }
                ),
            Actions\DeleteAction::make(),
        ];
    }

    public function fetchEvents(array $fetchInfo): array
    {
        return Event::query()
            ->whereIn('calendar_id', $this->selectedCalendarIds)
            ->where('start_at', '>=', $fetchInfo['start'])
            ->where('end_at', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn (Event $event) => [
                    'id' => $event->id,
                    'title' => $event->title,
                    'location' => $event->location,
                    'description' => $event->description,
                    'color' => $event->color,
                    'start' => $event->start_at,
                    'end' => $event->end_at,
                ]
            )
            ->all();
    }

    public function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('calendar_id')
                ->relationship('calendar', 'name', modifyQueryUsing: fn ($query) => $query->where('user_id', auth()->id())->orWhere('visibility', 'public'))
                ->getOptionLabelFromRecordUsing(fn ($record) => $record->name . ' - ' . str($record->visibility->value)->upper())
                ->required(),
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
                    Forms\Components\DateTimePicker::make('start_at')
                        ->required(),
                    Forms\Components\DateTimePicker::make('end_at')
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
