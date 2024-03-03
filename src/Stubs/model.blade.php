namespace Generaltools\Crudable\Models;


use Illuminate\Database\Eloquent\Model;
use Generaltools\Crudable\Classes\Crudable;
use Generaltools\Crudable\Classes\Entity\Relation\Relation;

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
        ->with({{ ...$Relation->with }})
    @endif
    @if (!empty($Relation->withPivot))
        ->withPivot({!! \Generaltools\Crudable\Utils\Convertor::arrayToBladeString($Relation->withPivot) !!})
    @endif
    @if ($Relation->withTimestamps)
        ->withTimestamps()
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


///////// Helpers /////////
public function saveRelated($related, $value, $saveType = null)
{
    if ($related->save_method == Relation::ASSOCIATED_SAVE_METHOD) {
        $model = app()->make(Crudable::class)->loadModel($related->name)->find(request()->input($related->name));
        $this->{$related->name}()->associate($model);
        $this->save();
    }
    else if ($related->method_name == Relation::SAVEMANY_SAVE_METHOD) {
        $models = array_map(fn ($value) => app()->make(Crudable::class)->loadModel($related->name)->find($value), request()->input($related->name));
        $this->{$related->name}()->saveMany($models);
    }
    else if ($related->method_name == Relation::SYNC_SAVE_METHOD)
        $this->{$related->name}()->sync(request()->input($related->name));
    else
        $this->{$related->name}()->sync(request()->input($related->name));
}


}
