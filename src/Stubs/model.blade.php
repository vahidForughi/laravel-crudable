namespace Generaltools\Crudable\Models;


use Illuminate\Database\Eloquent\Model;
use Generaltools\Crudable\Classes\Crudable;

@if($Entity->slug)
    use Spatie\Sluggable\HasSlug;
    use Spatie\Sluggable\SlugOptions;
@endif


class {{ Generaltools\Crudable\Utils\Names::modelName($Entity->name) }} extends @if ($Entity->model_extended)
    \{{ $Entity->model_extended }}
@else
    Model
@endif
{

@foreach ($Entity->model_uses as $Use)
    use \{{ $Use }};
@endforeach

@if($Entity->slug)
    use HasSlug;
    public function getSlugOptions() : SlugOptions {
    return SlugOptions::create()
    ->generateSlugsFrom('{!! $Entity->slug !!}')
    ->saveSlugsTo('slug');
    }
@endif


///////// Properties /////////
protected $table = '{!! $Entity->getTable() !!}';
protected $fillable = [{!! \Generaltools\Crudable\Utils\Convertor::arrayToBladeString($Entity->fillable) !!}];
protected $guarded = [{!! \Generaltools\Crudable\Utils\Convertor::arrayToBladeString($Entity->guarded) !!}];
protected $hidden = [{!! \Generaltools\Crudable\Utils\Convertor::arrayToBladeString($Entity->hidden) !!}];
protected $appends = [{!! \Generaltools\Crudable\Utils\Convertor::arrayToBladeString($Entity->appends) !!}];
protected $casts = [{!! \Generaltools\Crudable\Utils\Convertor::arrayToBladeString($Entity->casts) !!}];


///////// Relations /////////
@foreach($Entity->relations as $Relation)
    public function {{ $Relation->name }}()
    {
    return $this->{{ $Relation->method_name }}({!! \Generaltools\Crudable\Utils\Convertor::arrayToBladeString($Relation->method_args) !!})
    @if (!empty($Relation->with))
        ->with({{ ...$Relation->with }});
    @endif
    @if (!empty($Relation->withPivot))
        ->withPivot({{ ...$Relation->withPivot }});
    @endif
    @if ($Relation->withTimestamps)
        ->withTimestamps();
    @endif
    ;
    }
@endforeach


///////// Getters & Setters /////////
@foreach ($Entity->getters as $key => $Getter)
    public function get{!! Str::studly($Getter->name) !!}Attribute($value)
    {
    return Crudable::entity('{!! $Entity->name !!}')->getters[{{ $key }}]->call($value);
    }
@endforeach
@foreach ($Entity->setters as $key => $Setter)
    public function set{!! Str::studly($Setter->name) !!}Attribute($value)
    {
    $this->attributes['{!! $Setter->name !!}'] = Crudable::entity('{!! $Entity->name !!}')->setters[{{ $key }}]->call($value);
    }
@endforeach
}

