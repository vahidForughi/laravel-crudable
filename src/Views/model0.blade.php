namespace Generaltools\Crudable\Models;


use Illuminate\Database\Eloquent\Model;

@if($Slug)
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
@endif


class {{ $Name }} extends @if ($Extended) \{{ $Extended }} @else Model @endif
{
    @foreach ($Uses as $Use)
        use \{{ $Use }};
    @endforeach

    @if($Slug)
    use HasSlug;
    public function getSlugOptions() : SlugOptions {
        return SlugOptions::create()
            ->generateSlugsFrom('{!! $Slug !!}')
            ->saveSlugsTo('slug');
    }
    @endif

    @foreach ($Getters as $Getter)
        public function get{!! Str::camel($Getter->name) !!}Attribute($value)
        {
            return {!! ($Getter->callback)($value) !!};
        }
    @endforeach
    @foreach ($Setters as $Setter)
        public function set{!! Str::camel($Setter->name) !!}Attribute($value)
        {
            $this->attributes['{!! $Setter->name !!}'] = {!! ($Setter->callback)($value) !!};
        }
    @endforeach

    protected $table = '{!! $Table !!}';
    protected $fillable = [{!! $Convertor::arrayToBladeString($Fillable) !!}];
    protected $guarded = [{!! $Convertor::arrayToBladeString($Guarded) !!}];
    protected $hidden = [{!! $Convertor::arrayToBladeString($Hidden) !!}];
    protected $appends = [{!! $Convertor::arrayToBladeString($Appends) !!}];
    protected $casts = [{!! $Convertor::arrayToBladeString($Casts) !!}];

    @foreach($Relations as $Relation)
    public function {{ $Relation->name }}()
    {
        return $this->{{ $Relation->method_name }}({!! $Convertor::arrayToBladeString($Relation->method_args) !!})
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
}

