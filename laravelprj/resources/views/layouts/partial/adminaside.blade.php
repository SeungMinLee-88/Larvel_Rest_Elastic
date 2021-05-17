<p class="lead">
    {!! icon('check') !!} AdminReserve
</p>
<ul class="list-unstyled">
    <ul>
        @forelse($sidemenus as $sidemenu)
            <li class="">
                <a href="{{ route('admin.reserve', ['hallid' => $sidemenu->id])}}">{{$sidemenu->hallname}} Status
                </a>
            </li>
        @empty
        @endforelse
    </ul>
</ul>

<p class="lead">
    {!! icon('check') !!} ReserveList
</p>

<ul class="list-unstyled">
    <ul>
    @forelse($sidemenus as $sidemenu)
        <li class="">
            <a href="{{ route('admin.reservelist',["hallid" => $sidemenu->id])}}">{{$sidemenu->hallname}} Reserve Status
            </a>
        </li>
    @empty

    @endforelse
    </ul>
</ul>

<p class="lead">
    {!! icon('check') !!} Manage User
</p>
<ul class="list-unstyled">
    <ul>
    <li class="">
        <a href="{{ route('admin.manageruserlist')}}">User management
        </a>
    </li>
    </ul>
</ul>

