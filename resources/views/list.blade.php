
<ul class="tree">
    <li @if (!count($data->filiados)) class="last"   @endif>{{$data->name}}</li>
    @if (count($data->filiados))
       @each('list', $data->filiados, 'data', 'list.empty')
    @endif
</ul>
