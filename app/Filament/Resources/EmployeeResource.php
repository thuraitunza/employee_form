<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use DateTime;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('employees')
                        ->label('Employees Info')
                        ->schema([
                            TextInput::make('eng_name')
                                ->label('Employee Name (English)')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('mm_name')
                                ->label('Employee Name (Myanmar)')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('father_name')
                                ->required()
                                ->maxLength(255),
                            DatePicker::make('date_of_birth')
                                ->required()
                                ->format('Y/m/d'),
                            TextInput::make('race')
                                ->required()
                                ->maxLength(255),
                            Select::make('religion')
                                ->options([
                                    'Islam' => 'Islam',
                                    'Christian' => 'Christian',
                                    'Hindu' => 'Hindu',
                                    'Buddhism' => 'Buddhism',
                                    'Jainism' => 'Jainism',
                                    'Others' => 'Others',
                                ]),
                            Select::make('nationality')
                                ->options([
                                    'Myanmar' => 'Myanmar',
                                    'Others' => 'Others',
                                ]),
                            Select::make('vacancy')
                                ->options([
                                    'Web Developer' => 'Web Developer',
                                    'Software Developer' => 'Software Developer',
                                    'Mobile Developer' => 'Mobile Developer',
                                    'UIUX Designer' => 'UIUX Designer',
                                    'Others' => 'Others',
                                ]),
                            TextInput::make('passport_no')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('driver_license_no')
                                ->required()
                                ->maxLength(255),
                            Fieldset::make('NRC')
                                ->schema([
                                    Select::make('nrc_code')
                                        ->options([
                                            '1' => '1',
                                            '2' => '2',
                                            '3' => '3',
                                            '4' => '4',
                                            '5' => '5',
                                            '6' => '6',
                                            '7' => '7',
                                            '8' => '8',
                                            '9' => '9',
                                            '10' => '10',
                                            '11' => '11',
                                            '12' => '12',
                                        ]),
                                    Select::make('nrc_r_m')
                                        ->options([
                                            'နိုင်' => 'နိုင်',
                                            'ဧည့်' => 'ဧည့်',
                                            'ပြု' => 'ပြု'
                                        ]),

                                    TextInput::make('nrc_number'),
                                ])->columns(3)->columnSpan(1),
                            Select::make('gender')
                                ->options([
                                    'Male' => 'Male',
                                    'Female' => 'Female',
                                    'Others' => 'Others',
                                ]),
                            Select::make('blood_type')
                                ->options([
                                    'A+' => 'A+',
                                    'A-' => 'A-',
                                    'B+' => 'B+',
                                    'B-' => 'B-',
                                    'AB+' => 'AB+',
                                    'AB-' => 'AB-',
                                    'O+' => 'O+',
                                    'O-' => 'O-',
                                ]),
                            Select::make('marital_status')
                                ->options([
                                    'Single' => 'Single',
                                    'Married' => 'Married',
                                    'Divorced' => 'Divorced',
                                    'Widowed' => 'Widowed',
                                    'Others' => 'Others',
                                ]),
                            TextInput::make('home_phone')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('mobile_phone')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('social_media_url')
                                ->url()
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(2),

                        ])->columns(3),

                    Wizard\Step::make('Background Info')
                        ->schema([
                            Repeater::make('educations')
                                ->relationship()
                                ->schema([
                                    TextInput::make('degree')->columnSpan(2),
                                    DatePicker::make('from_year')->format('Y/m/d'),
                                    DatePicker::make('to_year')->format('Y/m/d'),
                                    TextInput::make('school_college_university')->columnSpan(2),
                                ])
                                ->addActionLabel('Add')
                                ->columns(6),
                            Repeater::make('experiences')
                                ->relationship()
                                ->schema([
                                    TextInput::make('job_title')->columnSpan(2),
                                    DatePicker::make('company_name')->columnSpan(2),
                                    DatePicker::make('from_date')->format('Y/m/d'),
                                    DatePicker::make('to_date')->format('Y/m/d'),
                                    TextInput::make('phone_number')
                                        ->columnSpan(2),
                                    TextInput::make('address')->columnSpan(4),
                                ])
                                ->addActionLabel('Add')
                                ->columns(6),

                            Section::make('references')
                                ->schema([
                                    TextInput::make('reference_person_name')
                                        ->relationship('references', 'reference_person_name')
                                        ->label('Reference Person Name'),
                                    TextInput::make('job_position')
                                        ->relationship('references', 'job_position')
                                        ->label('Job Position'),
                                    TextInput::make('email_address')
                                        ->relationship('references', 'email_address')
                                        ->label('Email Address'),
                                    TextInput::make('phone_number')
                                        ->relationship('references', 'phone_number')
                                        ->label('Phone Number'),
                                ])->columns(4),

                            Section::make('families')
                                ->schema([
                                    TextInput::make('family_member_name')
                                        ->relationship('families', 'family_member_name')
                                        ->label('Family Member Name'),
                                    TextInput::make('relationship')
                                        ->relationship('families','relationship')
                                        ->label('Relationship'),
                                    DatePicker::make('date_of_birth')
                                        ->relationship('families', 'date_of_birth')
                                        ->label('Date of Birth')->format('Y/m/d'),
                                    TextInput::make('occupation')
                                        ->relationship('families', 'occupation')
                                        ->label('Occupation'),
                                    TextInput::make('phone_number')
                                        ->relationship('families', 'phone_number')
                                        ->label('Contact Phone No.'),
                                    TextInput::make('address')
                                        ->relationship('families', 'address')
                                        ->label('Contact Address'),
                                ])->columns(4),
                        ]),

                    Wizard\Step::make('Other Info')
                        ->schema([
                            Section::make('addresses')
                                ->schema([
                                    Select::make('country')
                                    ->relationship('addresses', 'country')
                                        ->options([
                                            'Myanmar' => 'Myanmar',
                                            'Others' => 'Others',
                                        ]),
                                    Select::make('state')
                                        ->relationship('addresses','state')
                                        ->options([
                                            'Yangon' => 'Yangon',
                                        ]),
                                    Select::make('township')
                                        ->relationship('addresses', 'township')
                                        ->options([
                                            'Yangon' => 'Yangon',
                                        ]),
                                    TextInput::make('street_address')->relationship('addresses','street_address'),
                                ])->columns(2),
                        ])

                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
