<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('name')
                    ->required()
                    ->label('Project Name'),
                TextInput::make('description')
                    ->label('Description'),
                DatePicker::make('start_date')
                    ->required()
                    ->label('Start Date')
                    ->date(),
                DatePicker::make('end_date')
                    ->required()
                    ->label('End Date')
                    ->date(),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'in progress' => 'In Progress',
                        'completed' => 'Completed',
                    ])
                    ->required()
                    ->label('Status'),
                Select::make('priority')
                    ->options([
                        'low' => 'Low',
                        'medium' => 'Medium',
                        'high' => 'High',
                    ])
                    ->required()
                    ->label('Priority'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('name')
                    ->label('Project Name'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description'),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Start Date')
                    ->date(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('End Date')
                    ->date(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'in progress' => 'warning',
                        'completed' => 'success',
                        'pending' => 'gray',
                        'cancelled' => 'danger',
                        default => 'secondary',
                    }),
                Tables\Columns\TextColumn::make('priority')
                    ->label('Priority')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'high' => 'danger',
                        'medium' => 'warning',
                        'low' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('progress')
                    ->label('Progress')
                    ->formatStateUsing(function ($record) {
                        $totalTasks = $record->tasks()->count();
                        $completedTasks = $record->tasks()->where('status', 'completed')->count();

                        $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
                        return round($progress) . '%';
                    })
                    ->color(fn($state) => $state === '0%' ? 'gray' : ($state === '100%' ? 'green' : 'yellow'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Manager')
                    ->sortable()
                    ->searchable()
                    ->color('blue'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
