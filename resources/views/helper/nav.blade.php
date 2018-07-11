<ul role="tablist" class="nav {{ $nav_class or '' }}">
    @foreach ($tabs as $tab)
        <li role="presentation" class="{{ $tab['class'] or '' }}">
          <a href="#{{ $tab['id'] }}" aria-controls="default" role="tab" data-toggle="tab">{{ $tab['title'] }}
              @if($tab['isNew'])
                <i class="newIcon">N</i>
              @endif
          </a>
        </li>
    @endforeach
</ul>
