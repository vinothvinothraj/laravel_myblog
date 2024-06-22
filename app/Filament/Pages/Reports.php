<?php

namespace App\Filament\Pages;

use App\Models\RadioAdverts;
use App\Models\TvAdverts;
use App\Models\MainStream;
use Filament\Pages\Page;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Facades\Validator;
use App\Models\Report;
use App\Models\MainStreamMedia;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;


class Reports extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.reports';

    public $stepName = '';

    public $table;

    // Form state properties
    public $form_state = [

        'district' => '',
        'electorate' => '',
        'candidate' => '',
        'description' => '',
        'report_category' => '',
        'type' => '',

        //TV Advertisement
        'name_of_tv_channel' => '',
        'date' => '',
        'time' => '',
        'duration_from' => '',
        'duration_to' => '',
        'repetition' => false,
        'repetition_count' => 0,
        'cost' => '',
        'other_details' => '',
        'evidence' => '',

    ];


    protected function getFormSchema(): array
    {
        return [
            Wizard::make([
                Step::make('General')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('form_state.district')->label('District')
                                ->options([
                                    'colombo' => 'colombo'
                                ])
                                ->native(false)->required()
                                ->afterStateUpdated(fn(callable $set) => $set('form_state.electorate', null)),

                            Select::make('form_state.electorate')->label('Electorate')
                                ->options([
                                    'colombowest' => 'colombowest'
                                ])
                                ->reactive()
                                ->required()
                                ->native(false),
                            Select::make('form_state.candidate')
                                ->label('Select Candidate')
                                ->options([
                                    'anura' => 'Anura',
                                ])
                                ->columnSpanFull()
                                ->required()
                                ->native(false),
                            Textarea::make('form_state.description')->label('Description')
                                ->required()
                                ->maxLength(255)
                                ->columnSpanFull(),
                            Select::make('form_state.report_category')
                                ->label('Report Category')
                                ->options([
                                    'Mainstream' => 'Mainstream',
                                    'Social Media' => 'Social Media',
                                    'Public Campaigns' => 'Public Campaigns',
                                    'Public Events' => 'Public Events',
                                    'Press Conferences and Launching Ceremonies' => 'Press Conferences and Launching Ceremonies',
                                    'Campaign Office' => 'Campaign Office',
                                ])
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $this->form_state['report_category'] = $state;
                                    $set('form_state.type', null);
                                    $this->updateStepName($state);
                                })
                                ->required()
                                ->native(false),
                            Select::make('form_state.type')->label('Types')
                                ->options(function (callable $get) {
                                    $category = $get('form_state.report_category');
                                    if ($category === 'Mainstream') {
                                        return [
                                            'tv_Advertisement' => 'TV Advertisement',
                                            'radio_Advertisement' => 'Radio Advertisement',
                                            'newspaper_Advertisement' => 'Newspaper Advertisement',

                                        ];
                                    } elseif ($category === 'Social Media') {
                                        return [
                                            'option1' => 'Option 1',
                                            'option2' => 'Option 2',
                                        ];
                                    } elseif ($category === 'Public Campaigns') {
                                        return [
                                            'option1' => 'Option 1',
                                            'option2' => 'Option 2',
                                        ];
                                    }
                                    return [];
                                })
                                ->reactive()
                                ->required()
                                ->native(false)
                            //->hidden(fn () => !in_array($this->form_state['report_category'], ['Mainstream', 'Other'])),
                        ]),
                    ]),
                Step::make($this->stepName)
                    ->schema([

                        //TV Advertisement
                        Section::make('TV Advertisement')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('form_state.name_of_tv_channel')->label('Name of the TV Channel')->required(),
                                    DatePicker::make('form_state.date')
                                        ->label('Date of the advertisement was played')
                                        ->required()
                                        ->maxDate(now()),
                                    TextInput::make('form_state.time')->label('Time')->type('time')->required(),
                                    TextInput::make('form_state.duration_from')->label('Duration From')->type('time')->required(),
                                    TextInput::make('form_state.duration_to')->label('Duration To')->type('time')->required(),
                                    Radio::make('form_state.repetition')
                                        ->label('Was there a repetition of the advertisement during the reported date?')
                                        ->required()
                                        ->options([
                                            true => 'Yes',
                                            false => 'No',
                                        ])->boolean()->inline(),
                                    TextInput::make('form_state.repetition_count')->label('How many times was the advertisement repeated?')->numeric()->required(),
                                    TextInput::make('form_state.cost')->label('Cost of the advertisement (If known)')->required()->numeric(),
                                    Textarea::make('form_state.other_details')->label('Any other details')->required()->maxLength(255)->columnSpanFull(),
                                    FileUpload::make('form_state.evidence')->multiple()->label('Upload evidence')->columnSpanFull(),
                                ]),
                            ])
                            ->hidden(fn() => $this->form_state['report_category'] !== 'Mainstream' || $this->form_state['type'] !== 'tv_Advertisement'),


                        // radio_Advertisement
                        Section::make('Radio Advertisement')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('form_state.name_of_radio_channel')->label('Name of the radio channel')->required(),
                                    DatePicker::make('form_state.date')
                                        ->label('Date of the advertisement was played')
                                        ->required()
                                        ->maxDate(now()),
                                    TextInput::make('form_state.time')->label('Time')->type('time')->required(),
                                    TextInput::make('form_state.duration_from')->label('Duration From')->type('time')->required(),
                                    TextInput::make('form_state.duration_to')->label('Duration To')->type('time')->required(),

                                    Radio::make('form_state.repetition')
                                        ->label('Was there a repetition of the advertisement during the reported date?')
                                        ->required()
                                        ->options([
                                            'yes' => 'Yes',
                                            'no' => 'No',
                                        ])->boolean()->inline(),

                                    TextInput::make('form_state.repetition_count')->label('How many times was the advertisement repeated?')->numeric()->required(),
                                    TextInput::make('form_state.cost')->label('Cost of the advertisement (If known)')->required()->numeric(),
                                    Textarea::make('form_state.other_details')->label('Any other details')->required()->maxLength(255)->columnSpanFull(),
                                    FileUpload::make('form_state.evidence')->multiple()->label('Upload evidence')->columnSpanFull(),
                                ]),
                            ])
                            ->hidden(fn() => $this->form_state['report_category'] !== 'Mainstream' || $this->form_state['type'] !== 'radio_Advertisement'),

                        // newspaper_Advertisement
                        Section::make('Newspaper Advertisement')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('form_state.name_of_news_paper')->label('Name of the newspaper')->required(),

                                    DatePicker::make('form_state.date')
                                        ->label('Date of the newspaper')
                                        ->required()
                                        ->maxDate(now()),

                                    TextInput::make('form_state.page')->label('Page')->numeric()->required(),
                                    TextInput::make('form_state.size')->label('Size of the advertisement')->numeric()->required(),
                                    TextInput::make('form_state.adv_type')->label('Type of the advertisement')->required(),
                                    TextInput::make('form_state.color')->label('Color')->required(),
                                    TextInput::make('form_state.cost')->label('Cost of the advertisement (If known)')->required()->numeric()->columnSpanFull(),
                                    Textarea::make('form_state.other_details')->label('Any other details')->required()->maxLength(255)->columnSpanFull(),
                                    FileUpload::make('form_state.evidence')->multiple()->label('Upload evidence')->required()->columnSpanFull(),
                                ]),
                            ])
                            ->hidden(fn() => $this->form_state['report_category'] !== 'Mainstream' || $this->form_state['type'] !== 'newspaper_Advertisement'),
                    ]),
            ])->submitAction(new HtmlString(Blade::render(<<<BLADE
            <x-filament::button
                type="submit"
                size="sm"
            >
                Submit
            </x-filament::button>
        BLADE))),
        ];
    }



    protected function updateStepName($reportCategory)
    {
        switch ($reportCategory) {
            case 'Mainstream':
                $this->stepName = 'Mainstream Cost Details';
                break;
            case 'Social Media':
                $this->stepName = 'Social Media Cost Details';
                break;
            case 'Public Campaigns':
                $this->stepName = 'Public Campaigns Cost Details';
                break;
            case 'Public Events':
                $this->stepName = 'Public Events Cost Details';
                break;
            case 'Press Conferences and Launching Ceremonies':
                $this->stepName = 'Press Conferences Cost Details';
                break;
            case 'Campaign Office':
                $this->stepName = 'Campaign Office Cost Details';
                break;
            default:
                $this->stepName = 'Cost Category';
                break;
        }
    }



    public function save()
    {
        $data = $this->form->getState();


        if (isset($data['form_state']['type']) && $data['form_state']['type'] === 'tv_Advertisement') {



            $report = Report::create([

                'district' => $data['form_state']['district'],
                'electorate' => $data['form_state']['electorate'],
                'candidate' => $data['form_state']['candidate'],
                'description' => $data['form_state']['description'],
                'report_category' => $data['form_state']['report_category'],
                'type' => $data['form_state']['type'],

            ]);

            $mainstreamMedia = MainStream::create([

                'report_id' => $report->id,
                'type' => $data['form_state']['type'],
                'cost' => $data['form_state']['cost'],
                'other_details' => $data['form_state']['other_details'],

            ]);


            $tvAdvertisementData = [
                'mainstream_id' => $mainstreamMedia->id,
                'name_of_tv_channel' => $data['form_state']['name_of_tv_channel'],
                'date' => $data['form_state']['date'],
                'time' => $data['form_state']['time'],
                'duration_from' => $data['form_state']['duration_from'],
                'duration_to' => $data['form_state']['duration_to'],
                'repetition' => $data['form_state']['repetition'],
                'repetition_count' => $data['form_state']['repetition_count'],
                'cost' => $data['form_state']['cost'],
                'other_details' => $data['form_state']['other_details'],
            ];

            TVAdverts::create($tvAdvertisementData);

            session()->flash('success', 'TV Advertisement data submitted successfully.');

        } elseif (isset($data['form_state']['type']) && $data['form_state']['type'] === 'radio_Advertisement') {




            $report = Report::create([

                'district' => $data['form_state']['district'],
                'electorate' => $data['form_state']['electorate'],
                'candidate' => $data['form_state']['candidate'],
                'description' => $data['form_state']['description'],
                'report_category' => $data['form_state']['report_category'],
                'type' => $data['form_state']['type'],

            ]);

            $mainstreamMedia = MainStream::create([

                'report_id' => $report->id,
                'type' => $data['form_state']['type'],
                'cost' => $data['form_state']['cost'],
                'other_details' => $data['form_state']['other_details'],

            ]);


            $radioAdvertisementData = [
                'mainstream_id' => $mainstreamMedia->id,
                'name_of_radio_channel' => $data['form_state']['name_of_radio_channel'],
                'date' => $data['form_state']['date'],
                'time' => $data['form_state']['time'],
                'duration_from' => $data['form_state']['duration_from'],
                'duration_to' => $data['form_state']['duration_to'],
                'repetition' => $data['form_state']['repetition'],
                'repetition_count' => $data['form_state']['repetition_count'],
                'cost' => $data['form_state']['cost'],
                'other_details' => $data['form_state']['other_details'],
            ];


            RadioAdverts::create($radioAdvertisementData);

            session()->flash('success', 'Radio Advertisement data submitted successfully.');
        } else {

            session()->flash('error', 'Invalid submission type or missing data.');
        }
    }

}
